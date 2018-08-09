<?php

namespace Cms\Model;

use Think\Model;

/**
 * 文章模型
 *
 * Class PostsModel
 * @package Cms\Model
 */
class PostsModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    /**
     * 可以插入数据的字段
     *
     * @var array
     */
    protected $insertFields = array(
        'POST_TITLE',
        'POST_CONTENT',
        'POST_TRANSLATE_ID',
        'POST_CATEGORY_ID',
        'POST_LANG',
        'POST_AUTHOR_ID',
        'POST_STATUS',
        'POST_ORDER',
        'SEO_TITLE',
        'SEO_KEYWORD',
        'SEO_DESCRIPTION',
        'PUBLISHED_TIME'
    );

    /**
     * 可以更新数据的字段
     *
     * @var array
     */
    protected $updateFields = array(
        'POST_TITLE',
        'POST_CONTENT',
        'POST_TRANSLATE_ID',
        'POST_CATEGORY_ID',
        'POST_STATUS',
        'POST_ORDER',
        'SEO_TITLE',
        'SEO_KEYWORD',
        'SEO_DESCRIPTION',
        'PUBLISHED_TIME',
        'MODIFIED_TIME',
        'DELETED_TIME'
    );

    /**
     * 获取文章分页数据
     *
     * @param $whereData
     * @param $offset
     * @param $size
     * @return array
     */
    public function getList($whereData, $offset, $size)
    {
        $where = $this->getWhere($whereData);
        $result = $this
            ->alias('a')
            ->where($where)
            ->field('a.POST_ID, a.POST_TITLE, a.POST_LANG, a.POST_AUTHOR_ID AS POST_AUTHOR, POST_STATUS, a.PUBLISHED_TIME, a.MODIFIED_TIME, a.POST_ORDER, b.CATEGORY_NAME, b.CATEGORY_PARENT')
            ->join('category b ON b.CATEGORY_ID = a.POST_CATEGORY_ID', 'LEFT')
            ->order('a.PUBLISHED_TIME DESC')
            ->limit($offset, $size)
            ->select();
        if ($result) {
            $categoryParent = D('Category')->getParent($whereData['language']);
            $parentList = array_reduce($categoryParent, function ($carry, $item) {
                $carry[$item['CATEGORY_ID']] = $item['CATEGORY_SLUG'];
                return $carry;
            });
            foreach ($result as $k => $v) {
                $parentSlug = isset($parentList[$v['CATEGORY_PARENT']]) ? $parentList[$v['CATEGORY_PARENT']] : '';
                $result[$k]['POST_URL'] = $this->getPostUrl($parentSlug, $v['POST_ID'], $v['PUBLISHED_TIME']);
            }
        }
        return $result ? $result : array();
    }

    /**
     * 生成文件访问链接
     *
     * @param $slug
     * @param $id
     * @param $publishedTime
     * @return string
     */
    private function getPostUrl($slug, $id, $publishedTime)
    {
        if ($slug == 'news') {
            $date = date('Y-m-d', strtotime($publishedTime));
            $url = "http://xxxx.com/{$slug}/{$date}/{$id}";
        } else {
            $url = "http://xxxx.com/{$slug}/{$id}";
        }
        return $url;
    }

    /**
     * 获取文章标签
     *
     * @param $ids
     * @return array|mixed
     */
    public function getTagsList($ids)
    {
        $tagList = array();
        $tags = $this->alias('a')
            ->field('c.TAG_NAME,b.POST_ID')
            ->join('posts_tags_relation b on b.POST_ID = a.POST_ID')
            ->join('tags c on c.TAG_ID = b.TAG_ID')
            ->where(array('b.POST_ID' => array('in', $ids)))
            ->select();
        if ($tags) {
            $tagList = array_reduce($tags, function ($carry, $item) {
                $carry[$item['POST_ID']][] = $item['TAG_NAME'];
                return $carry;
            });
        }
        return $tagList;
    }

    /**
     * 获取各个状态总文章数
     *
     * @param $language
     * @param $statusMap
     * @return mixed
     */
    public function getStatusCount($language, $statusMap)
    {
        $result = $this->field('COUNT(*) AS TOTAL, POST_STATUS')
            ->where(array('POST_LANG' => $language, 'POST_STATUS' => array('in', $statusMap)))
            ->group('POST_STATUS')
            ->select();
        if ($result) {
            $statusCount = array_reduce($result, function ($carry, $item) {
                $carry[$item['POST_STATUS']] = $item['TOTAL'];
                return $carry;
            });
        } else {
            $statusCount = array_reduce($statusMap, function ($carry, $item) {
                $carry[$item] = 0;
                return $carry;
            });
        }
        return $statusCount;
    }

    /**
     * 获取置顶文章数量
     *
     * @param $language
     * @return mixed
     */
    public function getOrderPostsCount($language)
    {
        return $this->where(array('POST_LANG' => $language, 'POST_ORDER' => array('gt', 0)))->count();
    }

    /**
     * 获取总条数
     *
     * @param $whereData
     * @return mixed
     */
    public function getCount($whereData)
    {
        $where = $this->getWhere($whereData);
        return $this->alias('a')->where($where)->count();
    }

    /**
     * 获取搜索条件
     *
     * @param $whereData
     * @return array
     */
    private function getWhere($whereData)
    {
        $where = array();
        !empty($whereData['title']) && $where['a.POST_TITLE'] = $whereData['title'];
        !empty($whereData['category']) && $where['a.POST_CATEGORY_ID'] = $whereData['category'];
        !empty($whereData['language']) && $where['a.POST_LANG'] = $whereData['language'];
        $whereData['status'] !== false && $where['a.POST_STATUS'] = $whereData['status'];
        !empty($whereData['time']) && $where['DATE(a.PUBLISHED_TIME)'] = $whereData['time'];
        !empty($whereData['getOrder']) && $where['POST_ORDER'] = array('gt', 0);
        return $where;
    }

    /**
     * 添加文章
     *
     * @param $data
     * @return mixed
     */
    public function addPost($data)
    {
        try {
            $return = array('status' => true);
            //开启事务
            $this->startTrans();
            if (empty($data['PUBLISHED_TIME'])) {
                $data['PUBLISHED_TIME'] = array('exp', 'NOW()');
            }
            $data['POST_LAST_STATUS'] = $data['POST_STATUS'];
            //判断是否有当前对照语言版本存在
            if ($data['POST_TRANSLATE_ID']) {
                $count = $this->where(array('POST_TRANSLATE_ID' => $data['POST_TRANSLATE_ID'], 'POST_LANG' => $data['POST_LANG']))
                    ->count();
                if ($count > 0) {
                    throw new \Exception('当前语言版本已存在', 200);
                }
            }
            //添加
            $id = $this->add($data);
            if (!$id) {
                throw new \Exception('添加失败', 201);
            }
            //添加post和tag的关系
            if (!empty($data['POST_TAGS_ID'])) {
                foreach ($data['POST_TAGS_ID'] as $tag) {
                    $result = D('PostsTagsRelation')->addRelation($id, $tag);
                    if (!$result) {
                        throw new \Exception('添加关系失败', 202);
                    }
                }
            }
            $return['id'] = $id;
            $this->commit();
        } catch (\Exception $e) {
            $this->rollback();
            $return = array(
                'status' => false,
                'msg' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }
        return $return;
    }

    /**
     * 判断原标签和先标签的差异
     *
     * @param $source
     * @param $target
     * @return array
     */
    private function tagsDiff($source, $target)
    {
        $delete = [];
        $add = [];
        if (!empty($source) && !empty($target)) {
            foreach ($source as $item) {
                if (!in_array($item, $target)) {
                    $delete[] = $item;
                }
            }
            foreach ($target as $item) {
                if (!in_array($item, $source)) {
                    $add[] = $item;
                }
            }
        }
        return ['delete' => $delete, 'add' => $add];
    }

    /**
     * 修改文章
     *
     * @param $data
     * @return array
     */
    public function editPost($data)
    {
        try {
            $return = array('status' => true);
            //开启事务
            $this->startTrans();
            if (empty($data['PUBLISHED_TIME'])) {
                unset($data['PUBLISHED_TIME']);
            }
            $data['MODIFIED_TIME'] = array('exp', 'NOW()');
            $data['POST_LAST_STATUS'] = $data['POST_STATUS'];
            //判断id是否存在
            if (!$this->isExists($data['POST_ID'])) {
                throw new \Exception('该文章id不存在', 200);
            }
            //保存
            $result = $this->where(array('POST_ID' => $data['POST_ID']))->save($data);
            if (!$result) {
                throw new \Exception('修改失败', 201);
            }
            //判断原标签和先标签的差异
            $relationModel = D('PostsTagsRelation');
            $tags = $relationModel->getRelation($data['POST_ID']);
            $diff = $this->tagsDiff($tags, $data['POST_TAGS_ID']);
            //修改关系
            foreach ($diff['delete'] as $tag) {
                $result = $relationModel->deleteRelation($data['POST_ID'], $tag);
                if ($result === false) {
                    throw new \Exception('删除对应关系失败', 202);
                }
            }
            //添加关系
            foreach ($diff['add'] as $tag) {
                $result = $relationModel->addRelation($data['POST_ID'], $tag);
                if (!$result) {
                    throw new \Exception('添加对应关系失败', 203);
                }
            }
            //添加修改历史记录
            $relationModel = D('PostsRevisionHistory');
            $result = $relationModel->addHistory($data['POST_ID'], $data['POST_AUTHOR_ID']);
            if (!$result) {
                throw new \Exception('添加修改失败', 204);
            }
            $this->commit();
        } catch (\Exception $e) {
            $this->rollback();
            $return = array(
                'status' => false,
                'msg' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }
        return $return;
    }

    /**
     * 获取指定id的文章信息
     *
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        $post = $this->field('POST_ID, POST_TITLE, POST_CONTENT, POST_CATEGORY_ID, POST_TRANSLATE_ID, POST_LANG, POST_STATUS, PUBLISHED_TIME, SEO_KEYWORD, SEO_DESCRIPTION, SEO_TITLE, POST_ORDER')
            ->where(array('POST_ID' => $id))
            ->find();
        if ($post) {
            //父栏目
            $slug = D('Category')->getParentSlug($post['POST_CATEGORY_ID']);
            $post['POST_URL'] = $this->getPostUrl($slug, $post['POST_ID'], $post['PUBLISHED_TIME']);
        }
        return $post;
    }

    /**
     *  获取指定id的对照文章
     *
     * @param $translateID
     * @param $postID
     * @return mixed
     */
    public function getTranslate($translateID, $postID)
    {
        if ($translateID == 0) {
            $where = array(
                'POST_TRANSLATE_ID' => $postID
            );
        } else {
            $where = array(
                array('POST_ID' => array('neq', $postID)),
                array(
                    'POST_TRANSLATE_ID' => $translateID,
                    'POST_ID' => $translateID,
                    '_logic' => 'or'
                ),
            );
        }
        return $this->where($where)->select();
    }

    /**
     * 删除文章
     *
     * @param $id
     * @return array
     */
    public function deletePost($id)
    {
        try {
            $return = array('status' => true);
            //开启事务
            $this->startTrans();
            //判断id是否存在
            if (!$this->isExists($id)) {
                throw new \Exception('该文章id不存在', 200);
            }
            //删除
            $result = $this->where(array('POST_ID' => $id))->delete($id);
            if (!$result) {
                throw new \Exception('删除失败', 201);
            }
            //删除post和tag的关系
            $relationModel = D('PostsTagsRelation');
            $result = $relationModel->deleteRelation($id);
            if ($result === false) {
                throw new \Exception('清空tag关联失败', 202);
            }
            //删除文章历史修改记录
            $historyModel = D('PostsRevisionHistory');
            $historyModel->deleteHistory($id);
            if ($result === false) {
                throw new \Exception('清空文章历史修改失败', 203);
            }
            $this->commit();
        } catch (\Exception $e) {
            $this->rollback();
            $return = array(
                'status' => false,
                'msg' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }
        return $return;
    }

    /**
     * 软删除
     *
     * @param $id
     * @return mixed
     */
    public function softDeletePost($id)
    {
        try {
            $return = array('status' => true);
            //判断id是否存在
            if (!$this->isExists($id)) {
                throw new \Exception('该文章id不存在', 200);
            }
            //保存删除时间
            $result = $this->where(array('POST_ID' => $id))
                ->save(array('DELETED_TIME' => array('exp', 'NOW()'), 'POST_STATUS' => 3));
            if (!$result) {
                throw new \Exception('删除失败', 201);
            }
        } catch (\Exception $e) {
            $return = array(
                'status' => false,
                'msg' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }
        return $return;
    }

    /**
     * 还原文章
     *
     * @param $id
     * @return array
     */
    public function restorePost($id)
    {
        try {
            $return = array('status' => true);
            //判断id是否存在
            $status = $this->getLastStatus($id);
            if ($status === false) {
                throw new \Exception('该文章id不存在', 200);
            }
            $result = $this->where(array('POST_ID' => $id))
                ->save(array('POST_STATUS' => $status));
            if (!$result) {
                throw new \Exception('还原失败', 201);
            }
        } catch (\Exception $e) {
            $return = array(
                'status' => false,
                'msg' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }
        return $return;
    }

    /**
     * 判断id是否存在
     *
     * @param $id
     * @return bool
     */
    public function isExists($id)
    {
        $count = $this->where(array('POST_ID' => $id))->count();
        return $count > 0;
    }

    /**
     * 获取上一次状态
     *
     * @param $id
     * @return mixed
     */
    public function getLastStatus($id)
    {
        return $this->field('POST_LAST_STATUS')->where(array('POST_ID' => $id))->getField('POST_LAST_STATUS');
    }
}

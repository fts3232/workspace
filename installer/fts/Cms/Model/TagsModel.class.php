<?php

namespace Cms\Model;

use Think\Model;

class TagsModel extends Model
{
    protected $connection = 'DB_CONFIG1';

    protected $trueTableName = 'cms_tags';

    /**
     * 可以插入数据的字段
     *
     * @var array
     */
    protected $insertFields = array(
        'TAG_NAME',
        'TAG_SLUG',
        'TAG_DESCRIPTION',
        'TAG_LANG',
        'SEO_TITLE',
        'SEO_KEYWORD',
        'SEO_DESCRIPTION'
    );

    /**
     * 可以更新数据的字段
     *
     * @var array
     */
    protected $updateFields = array(
        'TAG_NAME',
        'TAG_SLUG',
        'TAG_DESCRIPTION',
        'SEO_TITLE',
        'SEO_KEYWORD',
        'SEO_DESCRIPTION',
        'MODIFIED_TIME'
    );

    /**
     * 获取tag分页数据
     *
     * @param $whereData
     * @param $offset
     * @param $size
     * @return array
     */
    public function getList($whereData, $offset, $size)
    {
        $where = $this->getWhere($whereData);
        $result = $this->field('TAG_ID, TAG_NAME, TAG_SLUG, TAG_DESCRIPTION')
            ->where($where)
            ->order('TAG_ID DESC')
            ->limit($offset, $size)
            ->select();
        if ($result) {
            foreach ($result as $k => $v) {
                $result[$k]['TAG_URL'] = $this->getUrl($v['TAG_SLUG']);
            }
        }
        return $result ? $result : array();
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
        return $this->where($where)->count();
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
        $where['TAG_LANG'] = $whereData['language'];
        !empty($whereData['name']) && $where['TAG_NAME'] = $whereData['name'];
        return $where;
    }

    /**
     * 获取指定tag信息
     *
     * @param string $id tagID
     * @return mixed
     */
    public function get($id)
    {
        $result = $this->field('TAG_ID, TAG_NAME, TAG_SLUG, TAG_DESCRIPTION, SEO_TITLE, SEO_KEYWORD, SEO_DESCRIPTION')
            ->where(array('TAG_ID' => $id))
            ->find();
        if ($result) {
            $result['TAG_URL'] = $this->getUrl($result['TAG_SLUG']);
        }
        return $result;
    }

    /**
     * 添加tag
     *
     * @param $data
     * @return bool|mixed
     */
    public function addTag($data)
    {
        try {
            $return = array('status'=>true);
            if ($this->isSlugExists($data['TAG_LANG'], $data['TAG_SLUG'])) {
                throw new \Exception('该标签别名已存在', 200);
            }
            $id = $this->add($data);
            if (!$id) {
                throw new \Exception('修改失败', 201);
            }
            $return['id'] = $id;
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
     * 更新tag
     *
     * @param $data
     * @return array
     */
    public function updateTag($data)
    {
        try {
            $return = array('status'=>true);
            if (!$this->isExists($data['TAG_ID'])) {
                throw new \Exception('该标签id不存在', 200);
            }
            $where = array(
                'TAG_ID' => $data['TAG_ID']
            );
            $result = $this->where($where)->save($data);
            if (!$result) {
                throw new \Exception('修改失败', 201);
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
     * 删除tag
     *
     * @param $id
     * @return array
     */
    public function deleteTag($id)
    {
        try {
            $return = array('status'=>true);
            if (!$this->isExists($id)) {
                throw new \Exception('该标签id不存在', 200);
            }
            $result = $this->delete($id);
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
     * 判断tag是否存在
     *
     * @param $id
     * @return bool
     */
    public function isExists($id)
    {
        $where = array('TAG_ID' => $id);
        $count = $this->where($where)->count();
        return $count > 0;
    }

    /**
     * 判断tag名称是否存在
     *
     * @param $language
     * @param $slug
     * @return mixed
     */
    public function isSlugExists($language, $slug)
    {
        $where = array('TAG_SLUG' => $slug, 'TAG_LANG' => $language);
        return $this->field('TAG_ID')->where($where)->getField('TAG_ID');
    }

    /**
     * 获取标签url
     *
     * @param $slug
     * @return string
     */
    protected function getUrl($slug)
    {
        $protocol = C('www.protocol');
        $domain = C('www.domain');
        $uri = "{$protocol}://{$domain}/tags/{$slug}";
        return $uri;
    }
}

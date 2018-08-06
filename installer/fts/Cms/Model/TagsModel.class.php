<?php

namespace Cms\Model;

use Think\Model;

class TagsModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    /**
     * 可以插入数据的字段
     *
     * @var array
     */
    protected $insertFields = array(
        'TAG_NAME',
        'TAG_SLUG',
        'TAG_DESCRIPTION',
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
    public function getAll($whereData, $offset, $size)
    {
        $where = $this->getWhere($whereData);
        $result = $this->field('TAG_ID, TAG_NAME, TAG_SLUG, TAG_DESCRIPTION')->where($where)->order('TAG_ID DESC')->limit($offset, $size)->select();
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
        return $this->field('TAG_ID, TAG_NAME, TAG_SLUG, TAG_DESCRIPTION, SEO_TITLE, SEO_KEYWORD, SEO_DESCRIPTION')
            ->where(array('TAG_ID' => $id))
            ->find();
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
            if ($this->isExists($data['TAG_NAME'], 'TAG_NAME')) {
                throw new \Exception('该标签名称已存在', 200);
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
     * @param $data
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
     * @param $name
     * @return bool
     */
    public function isExists($val, $type = 'TAG_ID')
    {
        if ($type == 'TAG_ID') {
            $where = array('TAG_ID' => $val);
        } else {
            $where = array('TAG_NAME' => $val);
        }
        return $this->field('TAG_ID')->where($where)->getField('TAG_ID');
    }
}

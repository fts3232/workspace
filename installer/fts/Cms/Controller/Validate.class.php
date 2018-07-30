<?php

namespace Cms\Controller;

use Cms\Common\Validator;

trait Validate
{
    protected function validate($data)
    {
        $rule = $this->validateRule;
        $msg = $this->validateMsg;
        //验证输入格式
        $validator = Validator::make($data, $rule, $msg);
        if ($validator->isFails()) {
            throw new \Exception($validator->getFirstError(), 100);
        }
        return true;
    }
}
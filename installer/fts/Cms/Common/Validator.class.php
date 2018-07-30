<?php

namespace Cms\Common;

class Validator
{
    private $error = array();

    private $data = array();

    private $rules = array();

    private $messages = array();

    private $result = true;

    private $stopValidate = false;

    private function __construct($data, $rules, $messages = array())
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->messages = $messages;
    }

    /**
     * 创建实例，并验证数据
     *
     * @param  array $data    要验证的数据数组
     * @param  array $rules   要验证的规则数组
     * @param  array $message 验证失败时的提示信息
     * @return Validator
     */
    public static function make($data, $rules, $message = array())
    {
        $instance = new self($data, $rules, $message);
        $instance->validate();
        return $instance;
    }

    /**
     * 验证流程
     *
     * @return $this
     */
    public function validate()
    {
        $rules = $this->rules;
        $messages = $this->messages;
        $data = $this->data;
        foreach ($data as $key => $v) {
            $this->stopValidate = false;
            $rules = isset($this->rules[$key]) ? $this->rules[$key] : null;
            if ($rules) {
                $rule = explode('|', $rules);
                foreach ($rule as $subRule) {
                    if ($this->stopValidate) {
                        break;
                    }
                    $msg = null;
                    if (isset($messages[$key]) && is_string($messages[$key])) {
                        $msg = $messages[$key];
                    } elseif (isset($messages[$key][$subRule])) {
                        $msg = $messages[$key][$subRule];
                    }
                    $result = false;
                    if (isset($data[$key])) {
                        $result = $this->validateRule($subRule, $data[$key]);
                    }
                    if ($result === false) {
                        $this->error[$key] = $msg;
                        $this->result = false;
                        break;
                    }
                }
            }
        }
        /*foreach ($rules as $key => $rule) {
            $this->stopValidate = false;
            $rule = explode('|', $rule);
            foreach ($rule as $subRule) {
                if ($this->stopValidate) {
                    break;
                }
                $msg = null;
                if (isset($messages[$key]) && is_string($messages[$key])) {
                    $msg = $messages[$key];
                } elseif (isset($messages[$key][$subRule])) {
                    $msg = $messages[$key][$subRule];
                }
                $result = false;
                if (isset($data[$key])) {
                    $result = $this->validateRule($subRule, $data[$key]);
                }
                if ($result === false) {
                    $this->error[$key] = $msg;
                    $this->result = false;
                    break;
                }
            }
        }*/
        return $this;
    }

    /**
     * 获取是否验证失败
     *
     * @return bool
     */
    public function isFails()
    {
        return !$this->result;
    }

    /**
     * 获取全部错误信息
     *
     * @return array
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * 获取第一个错误信息
     *
     * @return mixed|null
     */
    public function getFirstError()
    {
        return current($this->error);
    }

    /**
     * 验证规则
     *
     * @param  string $rule
     * @param  string $val
     * @return bool|mixed
     */
    private function validateRule($rule, $val)
    {
        $result = false;
        $params = array($val);
        $hasParam = stripos($rule, ':');
        if ($hasParam) {
            $params[] = substr($rule, $hasParam + 1);
            $rule = substr($rule, 0, $hasParam);
        }
        if (method_exists($this, $rule)) {
            $result = call_user_func_array(array($this, $rule), $params);
        }
        return $result;
    }

    /**
     * 判断是否整数
     *
     * @param  string $val
     * @return bool
     */
    private function int($val)
    {
        return is_int($val);
    }

    /**
     * 正则验证
     *
     * @param  string $val   要验证的值
     * @param  string $regex 正则表达式
     * @return bool
     */
    private function regex($val, $regex)
    {
        return preg_match_all($regex, $val) ? true : false;
    }

    /**
     * email格式验证
     *
     * @param  string $val 要验证的值
     * @return bool
     */
    private function email($val)
    {
        $regex = '/^[A-Za-z0-9_{4e00}-\x{9fa5}\.]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*(\.[a-zA-Z]{2,6})$/u';
        return self::regex($val, $regex);
    }

    /**
     * mobile格式验证
     *
     * @param  string $val 要验证的值
     * @return bool
     */
    private function mobile($val)
    {
        $regex = '/^(09\d{8}|[2,3,5,6,8,9]\d{7}|1(3[0-9]|4[579]|5[0-35-9]|66|7[35-8]|8[0-9]|99)\d{8})$/';
        return self::regex($val, $regex);
    }

    /**
     * qq格式验证
     *
     * @param  string $val 要验证的值
     * @return bool
     */
    private function qq($val)
    {
        $regex = '/^[0-9]{5,15}$/';
        return self::regex($val, $regex);
    }

    /**
     * 称谓验证
     *
     * @param  string $val 要验证的值
     * @return bool
     */
    private function title($val)
    {
        $titleMap = array('Mr', 'Mrs');
        return in_array($val, $titleMap);
    }

    /**
     * 国家验证
     *
     * @param  string $val 要验证的值
     * @return bool
     */
    private function country($val)
    {
        $countryMap = array('China', 'Hong Kong', 'Macau', 'Taiwan', 'Other');
        return in_array($val, $countryMap);
    }

    /**
     * swift code格式验证
     *
     * @param  string $val 要验证的值
     * @return bool
     */
    private function swiftCode($val)
    {
        $regex = '~^[A-Za-z0-9 /]{8,50}$~';
        return self::regex($val, $regex);
    }

    /**
     * 账号格式验证
     *
     * @param  string $val 要验证的值
     * @return bool
     */
    private function account($val)
    {
        $regex = "/^(9([13-589]0|28)\d{5}|3[01]\d{4})$/";
        return self::regex($val, $regex);
    }

    /**
     * 判断值是否为空
     *
     * @param  string $val 要验证的值
     * @return bool
     */
    private function required($val)
    {
        return $val === 0 || !empty($val);
    }

    /**
     * 判断值是否大于等于最小值
     *
     * @param  string|int $val 要验证的值
     * @param  string     $min 最小值
     * @return bool
     */
    private function min($val, $min)
    {
        return intval($val) >= intval($min);
    }

    /**
     * 判断值是否小于等于最大值
     *
     * @param  string|int $val 要验证的值
     * @param  string     $max 最大值
     * @return bool
     */
    private function max($val, $max)
    {
        return intval($val) <= intval($max);
    }

    /**
     * 名字格式验证
     *
     * @param  string $val 要验证的值
     * @return bool
     */
    private function name($val)
    {
        $regex = '/^[A-Za-z\x{4e00}-\x{9fa5}\s]{2,10}$/u';
        return self::regex($val, $regex);
    }

    /**
     * 银行格式验证
     *
     * @param  string $val 要验证的值
     * @return bool
     */
    private function bank($val)
    {
        $bankMap = __lang('common.register_bank_map');
        return array_key_exists($val, $bankMap);
    }

    /**
     * group验证
     *
     * @param  string|int $val 要验证的值
     * @return bool
     */
    private function group($val)
    {
        return $val >= 4 && $val <= 8;
    }

    /**
     * 账号类型判断
     *
     * @param  string|int $val 要验证的值
     * @return bool
     */
    private function acctSize($val)
    {
        $acctSizeMap = array(
            'mt4' => array(1, 2, 4, 6),
            'fXtrader' => array(1, 2)
        );
        $platform = isset($this->data['platform']) ? $this->data['platform'] : null;
        return $platform && isset($acctSizeMap[$platform]) && in_array($val, $acctSizeMap[$platform]);
    }

    /**
     * 账号币种判断
     *
     * @param  string $val 要验证的值
     * @return bool
     */
    private function acctCurrency($val)
    {
        $currencyMap = array(
            'mt4' => array(
                '1' => array('USD', 'HKD'),
                '2' => array('USD', 'HKD'),
                '4' => array('USD'),
                '6' => array('CNY')
            ),
            'fXtrader' => array(
                '1' => array('CNY', 'HKD'),
                '2' => array('CNY', 'HKD'),
            )
        );
        $platform = isset($this->data['platform']) ? $this->data['platform'] : null;
        $acctSize = isset($this->data['acct_size']) ? $this->data['acct_size'] : null;
        $map = array();
        if ($platform && $acctSize && isset($currencyMap[$platform][$acctSize])) {
            $map = $currencyMap[$platform][$acctSize];
        }
        return $map && in_array($val, $map);
    }

    /**
     * 验证码验证
     *
     * @param string $val    要验证的值
     * @param bool   $delete 是否删除session
     * @return bool
     */
    private function verifyCode($val, $delete = 'true')
    {
        if (!empty($_SESSION['verify'])) {
            $verifyCode = $_SESSION['verify'];
            if ($delete == 'true') {
                unset($_SESSION['verify']);
            }
            return $val == $verifyCode;
        }
        return false;
    }

    /**
     * 判断与验证字段的值是否一致
     *
     * @param string $val 要验证的值
     * @param string $key 验证字段的键值
     * @return bool
     */
    private function same($val, $key)
    {
        return isset($this->data[$key]) && $val == $this->data[$key] ? true : false;
    }

    /**
     * 判断与验证字段的值是否不一致
     *
     * @param string $val 要验证的值
     * @param string $key 验证字段的键值
     * @return bool
     */
    private function different($val, $key)
    {
        return isset($this->data[$key]) && $val != $this->data[$key] ? true : false;
    }

    /**
     * 判断密码格式是否正确
     *
     * @param string $val 要验证的值
     * @return bool
     */
    private function password($val)
    {
        $regex = '/^(?=.*[A-Za-z])(?=.*[0-9])[A-Za-z0-9]{6,8}$/';
        return $this->regex($val, $regex);
    }

    /**
     * 判断微信账号格式是否正确
     *
     * @param string $val 要验证的值
     * @return bool
     */
    private function wx($val)
    {
        $regex = '/^[A-Za-z]{1}[A-Za-z0-9-_]{5,19}$/';
        return $this->regex($val, $regex);
    }

    /**
     * 判断平台是否正确
     *
     * @param string $val 要验证的值
     * @return bool
     */
    private function platform($val)
    {
        $platformMap = array('mt4', 'fXtrader');
        return in_array($val, $platformMap);
    }

    /**
     * 判断身份类型是否正确
     *
     * @param string $val 要验证的值
     * @return bool
     */
    private function idType($val)
    {
        $idTypeMap = array('IdCard', 'Passport', 'Other');
        return in_array($val, $idTypeMap);
    }

    /**
     * 判断身份号码格式是否正确
     *
     * @param string $val 要验证的值
     * @return bool
     */
    private function idNum($val)
    {
        $regex = '/^[A-Za-z0-9\(\)]+$/';
        return $this->regex($val, $regex);
    }

    /**
     * 判断银行账号格式是否正确
     *
     * @param string $val 要验证的值
     * @return bool
     */
    private function bankAccount($val)
    {
        $regex = '/^[A-Za-z0-9- ]+$/';
        return $this->regex($val, $regex);
    }

    /**
     * 判断银行地址是否正确
     *
     * @param string $val 要验证的值
     * @return bool
     */
    private function bankAddress($val)
    {
        $regex = '/^[A-Za-z]+$/';
        return $this->regex($val, $regex);
    }

    /**
     * 判断银行支行是否正确
     *
     * @param string $val 要验证的值
     * @return bool
     */
    private function bankBranch($val)
    {
        $regex = '/^[A-Za-z0-9\x{4e00}-\x{9fa5}]+$/u';
        return $this->regex($val, $regex);
    }

    /**
     * 判断银行卡类型是否正确
     *
     * @param string $val 要验证的值
     * @return bool
     */
    private function cardType($val)
    {
        $map = array('DebitCard');
        return in_array($val, $map);
    }

    /**
     * 判断银行币种是否正确
     *
     * @param string $val 要验证的值
     * @return bool
     */
    private function bankCurrency($val)
    {
        $currencyMap = array('USD', 'CNY', 'HKD');
        return in_array($val, $currencyMap);
    }

    /**
     * 用于判断是否同意某某事项
     *
     * @param string $val 要验证的值
     * @return bool
     */
    private function agreement($val)
    {
        return strval($val) == '1';
    }

    /**
     * 验证值必须在给定的列表中
     *
     * @param $val
     * @param $map
     * @return bool
     */
    private function in($val, $map)
    {
        $map = explode(',', $map);
        return in_array($val, $map);
    }

    private function requiredIf($val, $param)
    {
        $params = explode(',', $param);
        if ($this->data[$params[0]] == $params[1]) {
            return !empty($val);
        }
        $this->stopValidate = true;
        return true;
    }

    /**
     * 判断值是否大于等于最小值
     *
     * @param  string|int $val 要验证的值
     * @param  string     $min 最小值
     * @return bool
     */
    private function addItems($val, $min)
    {
        return intval($val) >= intval($min);
    }

    /**
     * 判断菜单项格式是否正确
     *
     * @param $items
     * @return bool
     */
    private function menuItem($items)
    {
        if (!empty($items)) {
            foreach ($items as $item) {
                if (!$this->itemName($item['ITEM_NAME'])) {
                    return false;
                }
                if (!$this->required($item['ITEM_URL'])) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 判断栏目项格式是否正确
     *
     * @param $items
     * @return bool
     */
    private function categoryItem($items)
    {
        if (!empty($items)) {
            foreach ($items as $item) {
                if (!$this->itemName($item['CATEGORY_NAME'])) {
                    return false;
                }
                if (!$this->itemSlug($item['CATEGORY_SLUG'])) {
                    return false;
                }
                if (!$this->seoDescription($item['CATEGORY_DESCRIPTION'])) {
                    return false;
                }
                if (!$this->seoTitle($item['SEO_TITLE'])) {
                    return false;
                }
                if (!$this->seoKeyword($item['SEO_KEYWORD'])) {
                    return false;
                }
                if (!$this->seoDescription($item['SEO_DESCRIPTION'])) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 判断seo标题格式是否正确
     *
     * @param $val
     * @return bool
     */
    private function seoTitle($val)
    {
        if (!empty($val)) {
            $regex = '/^[0-9A-Za-z\x{4e00}-\x{9fa5}\s\|，]{1,50}$/u';
            return self::regex($val, $regex);
        }
        return true;
    }

    /**
     * 判断seo描述格式是否正确
     *
     * @param $val
     * @return bool
     */
    private function seoDescription($val)
    {
        if (!empty($val)) {
            $regex = '/^[0-9A-Za-z\x{4e00}-\x{9fa5}\s，。.\-\/]{1,300}$/u';
            return self::regex($val, $regex);
        }
        return true;
    }

    /**
     * 判断seo关键词格式是否正确
     *
     * @param $val
     * @return bool
     */
    private function seoKeyword($val)
    {
        if (!empty($val)) {
            $regex = '/^[0-9A-Za-z\x{4e00}-\x{9fa5}\s，]{1,85}$/u';
            return self::regex($val, $regex);
        }
        return true;
    }

    /**
     * item名字格式验证
     *
     * @param  string $val 要验证的值
     * @return bool
     */
    private function itemName($val)
    {
        $regex = '/^[0-9A-Za-z\x{4e00}-\x{9fa5}\s]{1,10}$/u';
        return self::regex($val, $regex);
    }

    /**
     * item名字格式验证
     *
     * @param  string $val 要验证的值
     * @return bool
     */
    private function itemSlug($val)
    {
        $regex = '/^[0-9A-Za-z]{1,10}$/u';
        return self::regex($val, $regex);
    }

    /**
     * 文章标题格式验证
     *
     * @param  string $val 要验证的值
     * @return bool
     */
    private function postTitle($val)
    {
        $regex = '/^[0-9A-Za-z\x{4e00}-\x{9fa5}\s，]{1,50}$/u';
        return self::regex($val, $regex);
    }

    /**
     * 语言验证
     *
     * @param  string $val 要验证的值
     * @return bool
     */
    private function lang($val)
    {
        $languageMap = array_keys(C('languageMap'));
        return in_array($val, $languageMap);
    }

    /**
     * 页面类型验证
     *
     * @param $val
     * @return bool
     */
    private function pageType($val)
    {
        $typeMap = array_keys(C('page.typeMap'));
        return in_array($val, $typeMap);
    }
}

import React from 'react';
import { Link } from 'react-router-dom';
import Component from '../../../components/component';
import Breadcrumb from '../../../components/breadcrumb';
import Panel from '../../../components/panel';
import Button from '../../../components/button';
import { Form, Input, Select, Textarea, FormItem } from '../../../components/form';
import DatePicker from '../../../components/date-picker';
import { Col, Row } from '../../../components/grid';

class Add extends Component {
    constructor(props) {
        super(props);
        this.onSubmit = this.onSubmit.bind(this);
    }

    onSubmit() {
        console.log(1);
    }

    render() {
        const breadcrumb = [{ 'name': '账簿', 'path': '/cash-book' }, { 'name': '添加', 'path': '/cash-book/add' }];
        const validateRule = {
            'tag'   : 'required',
            'amount': 'required|int'
        };
        const validateMsg = {
            'tag': {
                'required': '标签不能为空'
            },
            'amount': {
                'required': '金额不能为空',
                'int'     : '金额格式不正确'
            }
        };
        return (
            <Row>
                <Col span={12}>
                    <Breadcrumb data={breadcrumb}/>
                </Col>
                <Col span={12}>
                    <Panel>
                        <Form onSubmit={this.onSubmit} validateRule={validateRule} validateMsg={validateMsg}>
                            <FormItem label="日期" labelCol={{ span: 2 }} wrapperCol={{ span: 10 }}>
                                <DatePicker name="date" id="form-date"/>
                            </FormItem>
                            <FormItem label="标签" labelCol={{ span: 2 }} wrapperCol={{ span: 10 }}>
                                <Input name="tag" placeholder="请输入标签" value="22" id="form-tag"/>
                            </FormItem>
                            <FormItem label="类型" labelCol={{ span: 2 }} wrapperCol={{ span: 10 }}>
                                <Select data={{ 1: '支出', 2: '收入' }} name="type" id="form-type"/>
                            </FormItem>
                            <FormItem label="金额" labelCol={{ span: 2 }} wrapperCol={{ span: 10 }}>
                                <Input name="amount" placeholder="请输入金额" id="form-amount"/>
                            </FormItem>
                            <FormItem label="描述" labelCol={{ span: 2 }} wrapperCol={{ span: 10 }}>
                                <Textarea name="description" placeholder="请输入描述" id="form-description"/>
                            </FormItem>
                            <FormItem wrapperCol={{ span: 12 }} className="text-right">
                                <Button category="info" type="submit">添加</Button>
                                <Link to="/cash-book">
                                    <Button>返回</Button>
                                </Link>
                            </FormItem>
                        </Form>
                    </Panel>
                </Col>
            </Row>
        );
    }
}

Add.propTypes = {};

Add.defaultProps = {};

// 导出组件
export default Add;
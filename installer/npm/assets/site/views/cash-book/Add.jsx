import React from 'react';
import { Link } from 'react-router-dom';
import superagent from 'superagent';
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
        this.state = {
            tag: {}
        };
    }

    componentDidMount() {
        this.setState({ 'tag': { 1: '车费', 2: '饭钱' } });
    }

    onSubmit(formData) {
        console.log(1);
        console.log(formData);
        new Promise((resolve, reject) => {
            const url = 'http://localhost:8000/api/cashBook/add';
            superagent.post(url)
                .send(formData)
                .end((err, res) => {
                    if (typeof res !== 'undefined' && res.ok) {
                        resolve(JSON.parse(res.text));
                    } else {
                        reject(err);
                    }
                });
        }).then((data) => {
            console.log(data);
        });
    }

    render() {
        const breadcrumb = [{ 'name': '账簿', 'path': '/cash-book' }, { 'name': '添加', 'path': '/cash-book/add' }];
        const validateRule = {
            'date'  : 'required',
            'tag'   : 'required',
            'amount': 'required|int'
        };
        const validateMsg = {
            'date': {
                'required': '日期不能为空'
            },
            'tag': {
                'required': '标签不能为空'
            },
            'amount': {
                'required': '金额不能为空',
                'number'  : '金额格式不正确'
            }
        };
        const { tag } = this.state;
        return (
            <div>
                <Row>
                    <Col span={12}>
                        <Breadcrumb data={breadcrumb}/>
                    </Col>
                </Row>
                <Row>
                    <Col span={12}>
                        <Panel>
                            <Form onSubmit={this.onSubmit} validateRule={validateRule} validateMsg={validateMsg}>
                                <FormItem label="日期" labelCol={{ span: 2 }} wrapperCol={{ span: 10 }}>
                                    <DatePicker name="date" id="form-date"/>
                                </FormItem>
                                <FormItem label="标签" labelCol={{ span: 2 }} wrapperCol={{ span: 10 }}>
                                    <Select data={tag} name="tag" id="form-tag"/>
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
                                    <Button type="info">添加</Button>
                                    <Link to="/cash-book">
                                        <Button>返回</Button>
                                    </Link>
                                </FormItem>
                            </Form>
                        </Panel>
                    </Col>
                </Row>
            </div>
        );
    }
}

Add.propTypes = {};

Add.defaultProps = {};

// 导出组件
export default Add;
import React from 'react';
import { Link } from 'react-router-dom';
import Component from '../../../components/component';
import Breadcrumb from '../../../components/breadcrumb';
import Panel from '../../../components/panel';
import Button from '../../../components/button';
import { Form, Input, Select, Textarea, Label, FormItem } from '../../../components/form';
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
            <div>
                <Breadcrumb data={breadcrumb}/>
                <Panel>
                    <Form onSubmit={this.onSubmit} validateRule={validateRule} validateMsg={validateMsg}>
                        <FormItem>
                            12342
                        </FormItem>
                        <Row gutter={16}>
                            <Col span={2}>
                                <Label text="日期"/>
                            </Col>
                            <Col span={10}>
                                <DatePicker name="date" value="2018-07-10"/>
                            </Col>
                        </Row>
                        <Input name="tag" label="标签" placeholder="请输入标签" value="22"/>
                        <Select name="type" label="类型" data={{ '1': '收入', '2': '支出' }}/>
                        <Input name="amount" label="金额" placeholder="请输入金额"/>
                        <Textarea name="description" label="描述" placeholder="请输入描述"/>
                        <div className="text-right">
                            <Button category="info" type="submit">添加</Button>
                            <Link to="/cash-book">
                                <Button>返回</Button>
                            </Link>
                        </div>
                    </Form>
                </Panel>
            </div>
        );
    }
}

Add.propTypes = {};

Add.defaultProps = {};

// 导出组件
export default Add;
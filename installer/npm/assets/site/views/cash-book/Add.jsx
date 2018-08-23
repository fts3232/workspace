import React from 'react';
import { Link } from 'react-router-dom';
import PropTypes from 'prop-types';
import Component from '../../../components/component';
import Breadcrumb from '../../../components/breadcrumb';
import Panel from '../../../components/panel';
import Button from '../../../components/button';
import { Form, Input, Select, Textarea } from '../../../components/form';

class Add extends Component {
    submit() {
        console.log(1);
        const { children } = this.props;
        React.Children.map(children, (child) => {
            console.log(child.validate());
        });
    }

    render() {
        const breadcrumb = [{ 'name': '账簿', 'path': '/cashBook' }, { 'name': '添加', 'path': '/cashBook/add' }];
        return (
            <div>
                <Breadcrumb data={breadcrumb}/>
                <Panel>
                    <Form onSubmit={this.submit}>
                        <Input label="日期" validateRule="required|date"/>
                        <Input label="标签" validateRule="required"/>
                        <Select label="类型" data={{ '1': '收入', '2': '支出' }}/>
                        <Input label="金额" validateRule="required|num"/>
                        <Textarea label="描述"/>
                        <div className="text-right">
                            <Button type="info">添加</Button>
                            <Link to="/cashBook">
                                <Button>返回</Button>
                            </Link>
                        </div>
                    </Form>
                </Panel>
            </div>
        );
    }
}

Add.propTypes = {
    children: PropTypes.object.isRequired
};

Add.defaultProps = {};

// 导出组件
export default Add;
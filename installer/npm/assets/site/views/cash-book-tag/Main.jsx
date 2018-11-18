import React from 'react';
import superagent from 'superagent';
import Component from '../../../components/component';
import Table from '../../../components/table';
import Breadcrumb from '../../../components/breadcrumb';
import Panel from '../../../components/panel';
import Button from '../../../components/button';
import { Col, Row } from '../../../components/grid';
import getApiUrl from '../../config/api.js';
import Modal from '../../../components/modal';
import Message from '../../../components/message';
import { Form, Input, FormItem } from '../../../components/form';

class Main extends Component {
    constructor(props) {
        super(props);
        this.modal = null;
        this.table = null;
    }

    onEditSubmit(data) {
        new Promise((resolve, reject) => {
            const url = getApiUrl('/api/cashBookTags/edit');
            superagent.post(url)
                .type('form')
                .send(data)
                .end((err, res) => {
                    if (typeof res !== 'undefined' && res.ok) {
                        resolve(JSON.parse(res.text));
                    } else {
                        reject(err);
                    }
                });
        }).then((res) => {
            if (res.status) {
                Message.success('修改成功', 3000);
                this.modal.onClose();
                this.table.reload();
            } else {
                Message.error('修改失败', 3000);
            }
            console.log(res);
        });
    }

    onAddSubmit(data) {
        new Promise((resolve, reject) => {
            const url = getApiUrl('/api/cashBookTags/add');
            superagent.post(url)
                .type('form')
                .send(data)
                .end((err, res) => {
                    if (typeof res !== 'undefined' && res.ok) {
                        resolve(JSON.parse(res.text));
                    } else {
                        reject(err);
                    }
                });
        }).then((res) => {
            if (res.status) {
                Message.success('添加成功', 3000);
                this.modal.onClose();
                this.table.reload();
            } else {
                Message.error('添加失败', 3000);
            }
            console.log(res);
        });
    }

    showEditModal(data) {
        const validateRule = {
            'name': 'required'
        };
        const validateMsg = {
            'name': {
                'required': '标签名称不能为空'
            }
        };
        const props = {
            'title'  : '编辑',
            'content': (
                <Form ref={(form)=>{ this.editForm = form; }} onSubmit={this.onEditSubmit.bind(this)} validateRule={validateRule} validateMsg={validateMsg}>
                    <FormItem label="名称" labelCol={{ span: 2 }} wrapperCol={{ span: 10 }}>
                        <Input name="name" placeholder="请输入标签名称" id="form-name" value={data.TAG_NAME}/>
                    </FormItem>
                    <Input type='hidden' name="id" value={data.TAG_ID}/>
                </Form>
            ),
            'onOk': ()=>{
                this.editForm.submit();
            }
        };
        this.modal = Modal.show(props);
    }

    showAddModal() {
        const validateRule = {
            'name': 'required'
        };
        const validateMsg = {
            'name': {
                'required': '标签名称不能为空'
            }
        };
        const props = {
            'title'  : '添加',
            'content': (
                <Form ref={(form)=> { this.addForm = form; }} onSubmit={this.onAddSubmit.bind(this)} validateRule={validateRule} validateMsg={validateMsg}>
                    <FormItem label="名称" labelCol={{ span: 2 }} wrapperCol={{ span: 10 }}>
                        <Input name="name" placeholder="请输入标签名称" id="form-name"/>
                    </FormItem>
                </Form>
            ),
            'onOk': ()=>{
                this.addForm.submit();
            }
        };
        this.modal = Modal.show(props);
    }

    showDeleteModal(data) {
        const props = {
            'title'  : '删除',
            'content': '是否确定删除当前记录',
            'onOk'   : ()=>{
                new Promise((resolve, reject) => {
                    const url = getApiUrl('/api/cashBookTags/delete');
                    superagent.post(url)
                        .type('form')
                        .send({ id: data.TAG_ID })
                        .end((err, res) => {
                            if (typeof res !== 'undefined' && res.ok) {
                                resolve(JSON.parse(res.text));
                            } else {
                                reject(err);
                            }
                        });
                }).then((res) => {
                    if (res.status) {
                        Message.success('删除成功', 3000);
                        this.modal.onClose();
                        this.table.reload();
                    } else {
                        Message.error('删除失败', 3000);
                    }
                    console.log(res);
                });
            }
        };
        this.modal = Modal.confirm(props);
    }

    render() {
        const column = {
            'ID': 'TAG_ID',
            '名称': 'TAG_NAME',
            '操作': (data) => (
                <div>
                    <Button type="info" onClick={()=>{ this.showEditModal(data); }}>修改</Button>
                    <Button type="danger" onClick={()=>{ this.showDeleteModal(data); }}>删除</Button>
                </div>
            )
        };
        const breadcrumb = [{ 'name': '标签', 'path': '/cash-book-tag' }];
        return (
            <Row>
                <Col span={12}>
                    <Breadcrumb data={breadcrumb}/>
                </Col>
                <Col span={12}>
                    <Panel>
                        <div className="margin-bottom-10">
                            <Button type="info" onClick={()=>{ this.showAddModal(); }}>添加</Button>
                        </div>
                        <Table dataSource={getApiUrl('/api/cashBookTags/get')} column={column} ref={(table)=>{ this.table = table; }}/>
                    </Panel>
                </Col>
            </Row>
        );
    }
}

Main.propTypes = {};

Main.defaultProps = {};

// 导出组件
export default Main;
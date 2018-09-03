import superagent from 'superagent';
import React from 'react';
import Component from '../../../components/component';
import Breadcrumb from '../../../components/breadcrumb';
import { Col, Row } from '../../../components/grid';

class Comic extends Component {
    constructor(props) {
        super(props);
        this.state = {
            'data': []
        };
    }

    componentDidMount() {
        this.getData();
    }

    getData() {
        const _this = this;
        new Promise((resolve, reject) => {
            const url = 'http://localhost:8000/getData/comic';
            superagent.get(url)
                .end((err, res) => {
                    if (typeof res !== 'undefined' && res.ok) {
                        resolve(JSON.parse(res.text));
                    } else {
                        reject(err);
                    }
                });
        }).then((data) => {
            _this.setState({ 'data': data });
        });
    }

    render() {
        const breadcrumb = [{ 'name': '漫画', 'path': '/comic' }];
        return (
            <div className="comic-page">
                <Row>
                    <Col span={12}>
                        <Breadcrumb data={breadcrumb}/>
                    </Col>
                </Row>
                {this.state.data.map((v) => (
                    <div className="item">
                        <a href={v.url}>
                            <div className="cover" style={{ 'background': `url(${  v.cover  })` }}/>
                            <div className="info-box">
                                <h2 className="title">{v.title}</h2>
                                <span className="episodes">{v.episodes}</span>
                            </div>
                        </a>
                    </div>
                ))}
            </div>
        );
    }
}


Comic.propTypes = {};

Comic.defaultProps = {};

// 导出组件
export default Comic;
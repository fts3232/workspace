import React from 'react';
import PropTypes from 'prop-types';
import Component from '../../../components/component';

class Dialog extends Component {
    constructor(props) {
        super(props);
        this.state = {
            data       : {},
            thumb_index: 0
        };
    }

    onClose() {
        $(this.refs.dialog).hide();
        $('body').css({ overflow: 'auto' });
    }

    onCloseDownload() {
        $(this.refs.download).hide();
    }

    enlargeImage(src, i) {
        const _this = this;
        if (src.indexOf('cover.jpg') === -1) {
            this.setState({ 'thumb_index': i });
        }
        $(this.refs.big_image).find('img').attr('src', src);
        $(_this.refs.big_image).addClass('show');
    }

    show() {
        $(this.refs.dialog).show();
        $('body').css({ overflow: 'hidden' });
    }


    downloadShow() {
        $(this.refs.download).show();
    }

    downloadHide() {
        $(this.refs.download).hide();
    }

    bigImageClose() {
        $(this.refs.big_image).removeClass('show');
    }

    play(identifier) {
        this.parent().socketSend('play', identifier);
    }

    setInfo() {
        const identifier = prompt('输入番号', '');
        if (identifier !== null && identifier !== '') {
            this.parent().socketSend('update-movie', { 'identifier': identifier, 'movie_id': this.state.data.MOVIE_ID });
            this.parent().refs.log.resetData();
            this.parent().refs.log.setState({ 'toggle': true });
        }
    }

    parent() {
        return this.context.component;
    }

    searchStar(id) {
        this.parent().search({ 'star': id });
        this.onClose();
    }

    searchTag(id) {
        this.parent().search({ 'tag': id });
        this.onClose();
    }

    openDir(identifier) {
        this.parent().socketSend('openDir', identifier);
    }

    thumbPrev(e) {
        e.stopPropagation();
        let currentIndex = this.state.thumb_index;
        if (currentIndex === 0) {
            currentIndex = this.state.data.SAMPLE.length - 1;
        } else {
            currentIndex -= 1;
        }
        const src = this.state.data.SAMPLE[currentIndex].URL;
        $(this.refs.big_image).find('img').attr('src', src);
        this.setState({ 'thumb_index': currentIndex });
    }

    thumbNext(e) {
        e.stopPropagation();
        let currentIndex = this.state.thumb_index;
        if (currentIndex === this.state.data.SAMPLE.length - 1) {
            currentIndex = 0;
        } else {
            currentIndex += 1;
        }
        const src = this.state.data.SAMPLE[currentIndex].URL;
        $(this.refs.big_image).find('img').attr('src', src);
        this.setState({ 'thumb_index': currentIndex });
    }

    render() {
        const { data } = this.state;
        let star = [];
        if (typeof data.STAR !== 'undefined' && data.STAR !== '' && data.STAR !== null) {
            data.STAR.map((v)=>{
                star.push(
                    <div className="star-item" role="button" onClick={this.searchStar.bind(this, v.STAR_ID)}>
                        <img src={`http://localhost:8000/static/Star/${  v.STAR_NAME  }.jpg`}/>
                        <span className="tag">{v.STAR_NAME}</span>
                    </div>
                );
            });
        } else {
            star = (<span>暂无演员信息</span>);
        }               
        return (
            <div className="dialog">
                <div className="wrapper">
                    <div className="close" onClick={this.onClose.bind(this)}>X</div>
                    <h3>{data.TITLE}</h3>
                    <div className="box">
                        <div className="image">
                            <img src={data.IMAGE ? `http://localhost:8000/static/Movie/${  data.IDENTIFIER  }/cover.jpg` : 'http://localhost:8000/static/now_printing.jpg'} onClick={this.enlargeImage.bind(this, data.IMAGE)}/>
                        </div>
                        <div className="info">
                            <p>番号：{data.IDENTIFIER}</p>
                            <p>类别：</p>
                            <div className="tag-box">
                                {typeof data.TAG !== 'undefined' && data.TAG !== '' && data.TAG !== null && data.TAG.map((v)=>(<span className="tag" onClick={this.searchTag.bind(this, v.TAG_ID)}>{v.TAG_NAME}</span>))}
                            </div>
                            <div className="button-box">
                                <button onClick={this.downloadShow.bind(this)}>下载</button>
                                {data.PLAY === true && (
                                    <button onClick={this.play.bind(this, data.IDENTIFIER)}>播放</button>
                                )}
                                {data.PLAY === true && (
                                    <div className="row">
                                        <button className="set-info" onClick={this.setInfo.bind(this)}>设置资料来源</button>
                                        <button onClick={this.openDir.bind(this, data.IDENTIFIER)}>打开文件夹</button>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                    <div className="star">
                        {star}
                    </div>
                    <div className="thumb">
                        <ul>
                            {typeof data.SAMPLE !== 'undefined' && data.SAMPLE.map((v, k)=>(
                                <li onClick={this.enlargeImage.bind(this, v.URL, k)}><img src={v.URL}/></li>
                            ))}
                        </ul>
                    </div>
                </div>
                <div className="big-image" ref="big_image">
                    <div className="image-wrapper" onClick={this.bigImageClose.bind(this)}>
                        <div>
                            <img/>
                            <span onClick={this.thumbPrev.bind(this)} className="prev-btn">&lt;</span>
                            <span onClick={this.thumbNext.bind(this)} className="next-btn">&gt;</span>
                        </div>
                    </div>
                </div>
                <div className="download" ref="download">
                    <div className="wrapper">
                        <div className="close" onClick={this.downloadHide.bind(this)}>X</div>
                        <h4>下载链接</h4>
                        {typeof data.LINK !== 'undefined' && data.LINK.map((v)=>(<a href={v.LINK}>{v.LINK}</a>))}
                    </div>
                   
                </div>
            </div>
        );
    }
}

Dialog.contextTypes = {
    component: PropTypes.any
};

Dialog.propTypes = {

};

Dialog.defaultProps = {
    
};

// 导出组件
export default Dialog;
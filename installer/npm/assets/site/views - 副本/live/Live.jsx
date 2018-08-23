import css from './Scss/Main.scss';
import Component from '../../Components/Component';
import Header from './Header';

class Live extends Component {
    constructor(props) {
        super(props);
        this.state = {
            'data': []
        };
    }

    getData() {
        const _this = this;
        this.setState({ 'loading': true }, ()=>{
            new Promise((resolve, reject)=>{
                const url = 'http://localhost:8000/getData/live';
                request.get(url)
                    .end((err, res) => {
                        if (typeof res !== 'undefined' && res.ok) {
                            resolve(JSON.parse(res.text));
                        } else {
                            reject(err);
                        }
                    });
            }).then((data)=>{
                if (data != '') {
                    _this.setState({ 'loading': false, 'data': data });
                } else {
                    _this.setState({ 'loading': false });
                }
            }).catch((err)=>{
                _this.setState({ 'loading': false });
            });
        });
    }

    updateData() {
        const data = JSON.stringify({ 'event': 'updateLive', 'msg': '' });
        this.socket.send(data);
    }

    componentDidMount() {
        const socket = new WebSocket('ws://localhost:8000/socket');
        const _this = this;
        // 打开Socket 
        socket.onopen = function(event) { 
            console.log('连接成功');
            _this.getData();
            // 监听消息
            socket.onmessage = function(event) { 
                const data = JSON.parse(event.data);
                _this.refs.header.setState({ 'loading': false, 'data': data.msg });
            }; 
        };
        // 监听Socket的关闭
        socket.onclose = function(event) { 
            console.log('Client notified socket has closed', event); 
            // 关闭Socket.... 
            // socket.close() 
        }; 
        this.socket = socket;
    }

    getChildContext() {
        return {
            component: this
        };
    }

    render() {
        const group = [];
        const data = this.state.data;
        const groupName = {
            'douyu'  : '斗鱼',
            'huya'   : '虎牙',
            'panda'  : '熊猫',
            'longzhu': '龙珠'
        };
        for (const i in data) {
            const items = [];
            for (const j in data[i]) {
                const room_info = data[i][j][1];
                items.push(
                    <div className="item">
                        <a href={data[i][j][0]} target="_blank">
                            <img src={room_info.screenshot} />
                            <span className={this.classNames('state', { 'off': !room_info.state })}>{room_info.state ? '正在直播' : '已下播'}</span>
                            <div className="msg">
                                <p><span className="title">{room_info.room_name}</span></p>
                                <p>
                                    <span className="nickname">{room_info.nickname}</span>
                                    <span className="category">{room_info.category}</span>
                                </p>
                            </div>
                        </a>
                    </div>
                );
            }
            group.push(
                <div className="item-group">
                    <h3>{groupName[i]}</h3>
                    <div className="items">
                        {items}
                    </div>
                </div>
            );
        }
        return (
            <div ref="app" className="live-list-page">
                <Header ref="header" />
                {group}
            </div>
        );
    }
}

Live.childContextTypes = {
    component: React.PropTypes.any
};

Live.PropTypes = {
    
};

Live.defaultProps = {
    
};

// 导出组件
export default Live;
import Component from '../../Component';
import Scrollbar from '../../Scrollbar';
import parseTime from '../parseTime';
class TimePickerPanel extends Component {
	constructor(props){
		super(props)   
	}
	parent(){
		return this.context.component;
	}
    componentDidMount(){
    	this.scrollToOption()
    }
    componentDidUpdate(props) {
	    this.scrollToOption()
  	}
    scrollToOption() {
	    const list = this.refs.root.querySelectorAll('.time-spinner-wrapper');
	    for(let index in list){
	    	if(list[index].nodeType==1){
	    		list[index].querySelector('.scrollbar-wrapper').scrollTop = list[index].querySelector('.selected').offsetTop - 79
	    	}
	    }
	}
    getSeconds(){
    	const result = [];
		const {selectableRange} = this.props
	  	for(let i=1;i<=59;i++){
	  		result.push({
				value: i,
				disabled:false
			});
	  	}
		return result;
    }
    getHours(){
    	const result = [];
		const {selectableRange} = this.props
	  	for(let i=0;i<=23;i++){
	  		result.push({
				value: i,
				disabled:false
			});
	  	}
		return result;
    }
    getMinutes(){
    	const result = [];
		const {start,end,step,minTime,maxTime} = this.props
	  	for(let i=1;i<=59;i++){
	  		result.push({
				value: i,
				disabled:false
			});
	  	}
		return result;
    }
	render(){
		let seconds = this.getSeconds();
		let hours = this.getHours();
		let minutes = this.getMinutes();
		return(
			<div className="picker-panel time-spinner" ref='root'>
				<Scrollbar className="time-spinner-wrapper">
					<ul className="time-spinner-list">
	                {hours.map((v)=>{
	                	return (<li className={this.classNames('time-spinner-list-item',{'is-disabled':v.disabled,'selected':v.value==this.parent().state.time.hours})} onClick={()=>{this.parent().changeHour(v)}}>{v.value}</li>)
	                })}
	                </ul>
	            </Scrollbar>
				
	            <Scrollbar className="time-spinner-wrapper">
					<ul  className="time-spinner-list">
	                {minutes.map((v)=>{
	                	return (<li className={this.classNames('time-spinner-list-item',{'is-disabled':v.disabled,'selected':v.value==this.parent().state.time.minutes})} onClick={()=>{this.parent().changeMinute(v)}}>{v.value}</li>)
	                })}
	                </ul>
	            </Scrollbar>

				<Scrollbar className="time-spinner-wrapper">
					<ul  className="time-spinner-list">
	                {seconds.map((v)=>{
	                	return (<li className={this.classNames('time-spinner-list-item',{'is-disabled':v.disabled,'selected':v.value==this.parent().state.time.seconds})} onClick={()=>{this.parent().changeSecond(v)}}>{v.value}</li>)
	                })}
	                </ul>
	            </Scrollbar>
	            <div className="time-panel-footer">
	            	<button type="button" className="time-panel-btn cancel" onClick={()=>{this.parent().hide()}}>取消</button>
	            	<button type="button" className="time-panel-btn confirm" onClick={()=>{this.parent().hide()}}>确定</button>
	            </div>
			</div>
		)
	}
}

TimePickerPanel.contextTypes = {
  component: React.PropTypes.any
};

TimePickerPanel.PropTypes = {
	start:React.PropTypes.string,
	end:React.PropTypes.string,
	step:React.PropTypes.number,
	maxTime:React.PropTypes.string,
	minTime:React.PropTypes.string,
}

TimePickerPanel.defaultProps = {
	
}

export default TimePickerPanel;
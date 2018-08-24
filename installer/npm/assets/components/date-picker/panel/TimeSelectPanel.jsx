import Component from '../../Component';
import Scrollbar from '../../Scrollbar';
class TimeSelectPanel extends Component {
	constructor(props){
		super(props)   
	}
	getItems(){
		const result = [];
		const {start,end,step,minTime,maxTime} = this.props
	  	if (start && end && step) {
			let current = start;
			while (this.compareTime(current, end) <= 0) {
				result.push({
					value: current,
					disabled: this.compareTime(current, minTime) <= 0 || this.compareTime(current, maxTime) >= 0
				});
				current = this.nextTime(current, step);
			}
		}
		return result;
	}
	parseTime(time){
		const values = (time || '').split(':');
		if (values.length >= 2) {
		    const hours = parseInt(values[0], 10);
		    const minutes = parseInt(values[1], 10);

		    return {
		      hours,
		      minutes
		    };
		}
		/* istanbul ignore next */
		return null;
	}
	compareTime(time1,time2){
		const value1 = this.parseTime(time1);
		const value2 = this.parseTime(time2);

		const minutes1 = value1.minutes + value1.hours * 60;
		const minutes2 = value2.minutes + value2.hours * 60;

		if (minutes1 === minutes2) {
			return 0;
		}

		return minutes1 > minutes2 ? 1 : -1;
	}
	nextTime(time,step){
 		const timeValue = this.parseTime(time);
  		const stepValue = this.parseTime(step);
  		let next = {
  			hours:timeValue.hours,
  			minutes:timeValue.minutes
  		}
  		next.hours += stepValue.hours;
  		next.minutes += stepValue.minutes;
  		next.hours += Math.floor(next.minutes / 60);
  		next.minutes = next.minutes % 60
  		return (next.hours < 10 ? '0' + next.hours : next.hours) + ':' + (next.minutes < 10 ? '0' + next.minutes : next.minutes);
	}
	parent(){
		return this.context.component;
	}
	onClick(v){
        this.parent().handleItemClick(v)
    }
    componentDidMount(){
    	if(document.querySelector('.time-select .scrollbar-wrapper .selected')){
    		document.querySelector('.time-select .scrollbar-wrapper').scrollTop = document.querySelector('.time-select .scrollbar-wrapper .selected').offsetTop - 4 * 36
    	}
    }
	render(){
		let items = this.getItems();
		return(
			<div className="picker-panel time-select" ref='root'>
				<Scrollbar>
	                {items.map((v)=>{
	                	return (<div className={this.classNames('time-select-item',{'is-disabled':v.disabled,'selected':v.value==this.parent().state.value})} onClick={this.onClick.bind(this,v)}>{v.value}</div>)
	                })}
	            </Scrollbar>
			</div>
		)
	}
}

TimeSelectPanel.contextTypes = {
  component: React.PropTypes.any
};

TimeSelectPanel.PropTypes = {
	start:React.PropTypes.string,
	end:React.PropTypes.string,
	step:React.PropTypes.number,
	maxTime:React.PropTypes.string,
	minTime:React.PropTypes.string,
}

TimeSelectPanel.defaultProps = {
	
}

export default TimeSelectPanel;
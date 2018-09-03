import React from 'react';
import PropTypes from 'prop-types';
import classnames from 'classnames';
import ClickOutside from 'react-click-outside';
import Component from '../component';
import Icon from '../icon';

class Select extends Component {
    constructor(props) {
        super(props);
        this.showDropDown = this.showDropDown.bind(this);
        let value = props.multiple ? [] : '';
        const defaultValue = Object.keys(props.data).length > 0 ? Object.entries(props.data)[0][0] : null;
        if (!props.multiple) {
            value = props.value !== null ? props.value : defaultValue;
        }
        this.state = {
            'dropDown': false,
            'value'   : value
        };
    }

    componentDidMount() {
        const { name } = this.props;
        const { value } = this.state;
        const { setData } = this.context;
        setData(name, value);
    }

    onClick(val) {
        const { multiple, name } = this.props;
        const { setData } = this.context;
        let { value } = this.state;
        if (multiple) {
            if (value.includes(val)) {
                if (value.length === 1) {
                    value = [];
                } else {
                    value = value.splice(value.indexOf(val), 1);
                }
            } else {
                value.push(val);
            }
        } else {
            value = val;
        }
        setData(name, value);
        this.setState({
            value
        });
    }

    remove(val) {
        let { value } = this.state;
        if (value.length === 1) {
            value = [];
        } else {
            value = value.splice(value.indexOf(val), 1);
        }
        this.setState({
            value
        });
    }

    showDropDown() {
        this.setState({ 'dropDown': true });
    }

    handleClickOutside() {
        this.setState({ 'dropDown': false });
    }

    render() {
        const { data, name, id, placeholder, multiple } = this.props;
        const { dropDown, value } = this.state;
        return (
            <div className={this.classNames('select', { 'multiple': multiple })}>
                <div className="select-selection-render">
                    {multiple ? (
                        <div role="button" className="form-control select-placeholder" id={id} onClick={this.showDropDown} name={name}>
                            {placeholder}
                        </div>
                    ) : (
                        <div role="button" className="form-control select-selection-value" id={id} onClick={this.showDropDown} name={name}>
                            {data[value]}
                        </div>
                    )}
                    <ul>
                        {multiple && value.map((v, i) => (
                            <li
                                role="menuitem"
                                className={this.classNames('select-selection-choice')}
                                key={i}
                            >
                                <div className="select-selection-choice-content">{data[v]}</div>
                                <Icon name="close" onClick={()=>{ this.remove(v); }}/>
                            </li>
                        ))}
                    </ul>
                </div>
                <div className={classnames('select-dropdown', { 'active': dropDown })}>
                    <ul role="menu" className="select-dropdown-menu">
                        {Object.entries(data).map((v, i) => (
                            <li
                                role="menuitem"
                                className={this.classNames('select-dropdown-item', { 'select-dropdown-menu-item-selected': value.indexOf(v[0]) !== -1 })}
                                value={v[0]}
                                key={i}
                                onClick={this.onClick.bind(this, v[0])}
                            >{v[1]}
                            </li>
                        ))}
                    </ul>
                </div>
            </div>
        );
    }
}

Select.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    data       : PropTypes.object.isRequired,
    name       : PropTypes.string.isRequired,
    value      : PropTypes.oneOfType([PropTypes.string, PropTypes.number, PropTypes.array]),
    multiple   : PropTypes.bool,
    placeholder: PropTypes.string
};
Select.defaultProps = {
    value      : null,
    multiple   : false,
    placeholder: ''
};// 设置默认属性

Select.contextTypes = {
    setData: PropTypes.func
};

// 导出组件
export default ClickOutside(Select);
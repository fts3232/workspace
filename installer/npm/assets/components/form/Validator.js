class Validator {
    constructor(value, rules, msg) {
        this.value = value;
        this.rules = rules;
        this.msg = msg;
        this.error = {};
        this.validate();
    }

    validate() {
        const { msg } = this;
        let { rules } = this;
        rules = Object.entries(rules);
        const { length } = rules;
        for (let i = 0; i < length;i++) {
            const name = rules[i][0];
            let rule = rules[i][1];
            rule = rule.split('|');
            for (let j = 0, len = rule.length; j < len; j++) {
                if (typeof this[rule[j]] !== 'undefined' && !this[rule[j]](name)) {
                    this.error[name] = typeof msg[name][rule[j]] === 'undefined' ? msg[name] : msg[name][rule[j]];
                    break;
                }
            }
        };
    }

    isFail() {
        return Object.keys(this.error).length > 0 ;
    }

    getError() {
        return this.error;
    }

    required(name) {
        const { value } = this;
        if (typeof value[name] === 'undefined' || value[name] === '' || value[name] === null) {
            return false;
        }
        return true;
    }

    int(name) {
        const { value } = this;
        if (typeof value[name] !== 'undefined' && !Number.isInteger(parseInt(value[name], 0))) {
            return false;
        }
        return true;
    }

    number(name) {
        const { value } = this;
        if (typeof value[name] !== 'undefined' && !isNaN(parseFloat(value[name]))) {
            return false;
        }
        return true;
    }
}

export default Validator;
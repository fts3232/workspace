const throttle = (delay, action) => {
    let last = 0;
    return () => {
        const curr = +new Date();
        if (curr - last > delay) {
            action.apply(this, arguments);
            last = curr;
        }
    };
};
export default throttle;
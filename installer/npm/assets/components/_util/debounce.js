const debounce = (idle, action) => {
    let last = null;
    return () => {
        const ctx = this; const args = arguments;
        clearTimeout(last);
        last = setTimeout(() => {
            action.apply(ctx, args);
        }, idle);
    };
};

export default debounce;
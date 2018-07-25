const count = (state = 0, action) => {
    let count = state
    switch (action.type) {
        case 'increase':
            return count + 1;
        default:
            return state
    }
}

export default count;
import { createStore } from 'redux'

// Reducer 返回state 或者 执行对state的操作
function counter(state = { count: 100 }, action) {
    const count = state.count
    switch (action.type) {
        case 'increase':
            return { count: count + 1 }
        default:
            return state
    }
}

// Store 存放state和对state操作的方法
const store = createStore(counter)

export default store;
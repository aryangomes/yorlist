export default {
    'CHANGE_LIST'(state, payload){
        state.idList = payload;
    },


    'SET_ITEMS'(state, payload){
        state.items = payload;
    }
}
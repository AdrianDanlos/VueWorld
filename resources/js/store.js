import {
    isLoggedIn,
    logOut
} from "./shared/utils/auth";
export default {
    state: {
        lastSearch: {
            from: null,
            to: null
        },
        basket: {
            items: [],
        },
        isLoggedIn: false,
        user: {}
    },
    mutations: {
        setLastSearch(state, payload) {
            state.lastSearch = payload;
        },
        setBasket(state, payload) {
            state.basket = payload;
        },
        addToBasket(state, payload) {
            state.basket.items.push(payload);
        },
        removeFromBasket(state, payload) {
            //We iterate through all the items in the basket and remove the one that has the id we are passing on the payload.
            state.basket.items = state.basket.items.filter(item => item.bookable.id !== payload);
        },
        setUser(state, payload) {
            state.user = payload;
        },
        setIsLoggedIn(state, payload) {
            state.isLoggedIn = payload;
        }
    },
    actions: { //actions call mutations
        setLastSearch(context, payload) {
            context.commit('setLastSearch', payload); //We call the mutation that saves the payload in the vuex state.
            localStorage.setItem('lastSearch', JSON.stringify(payload)); //We save the payload in the localstorage
        },
        loadStoredState(context) {
            const lastSearch = localStorage.getItem('lastSearch');
            const lastBasket = localStorage.getItem('basket');
            //We save whatever is found in the localStorate to our vuex state
            if (lastSearch) {
                context.commit('setLastSearch', JSON.parse(lastSearch));
            }
            if (lastBasket) {
                context.commit('setBasket', JSON.parse(lastBasket));
            }

            context.commit("setIsLoggedIn", isLoggedIn());
        },
        addToBasket({
            commit,
            state
        }, payload) {
            //context.commit, context.state //Destructuring context object to exclusively get the methods we need.
            commit('addToBasket', payload);
            localStorage.setItem('basket', JSON.stringify(state.basket));
        },
        removeFromBasket({
            commit,
            state
        }, payload) {
            commit('removeFromBasket', payload);
            localStorage.setItem('basket', JSON.stringify(state.basket));
        },
        clearBasket({
            commit,
            state
        }, payload) {
            commit('setBasket', {
                items: []
            });
            localStorage.setItem('basket', JSON.stringify(state.basket));
        },
        async loadUser({
            commit,
            dispatch,
            state
        }) {
            if (isLoggedIn()) {
                try {
                    const currentUser = (await axios.get("/user")).data; //Get the current user
                    commit('setUser', currentUser);
                    commit('setIsLoggedIn', true);
                    localStorage.setItem('user', state.user);
                } catch (error) {
                    dispatch("logout"); //if an error happens loading the current user we logout.

                }
            }
        },
        logout({
            commit
        }) {
            commit("setUser", {});
            commit("setIsLoggedIn", false);
            logOut(); //Remove user from localStorage
        }
    },
    getters: {
        itemsInBasket: (state) => state.basket.items.length,
        //inBasketAlready returns a function instead of a value because we need to pass the bookable id to the inner function. This is the way Vue does it.
        inBasketAlready(state) {
            return function (id) {
                return state.basket.items.reduce(
                    //We iterate trough every item in the array. Let's imagine the bookable we are trying to add is already in the basket and it's in the 2nd place of the array.
                    //1st iter: false || false -- 2nd iter: false || true -- 3rd iter: true || false / ... When the iteration is over we return the result. We are reducing the array to a boolean value.
                    (result, item) => {
                        return result || item.bookable.id === id
                    },
                    false //initial value
                );
            }
        }
    }
};

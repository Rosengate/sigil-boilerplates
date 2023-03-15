import {defineStore} from "pinia";

export const loader = defineStore('loader', {
    state: () => ({
        isShowing: false
    }),
    actions: {
        start() {
            this.isShowing = true;
        },
        stop() {
            this.isShowing = false;
        }
    }
})
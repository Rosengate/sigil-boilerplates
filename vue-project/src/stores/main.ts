import {defineStore} from "pinia";
import {useStorage} from "@vueuse/core";

export const main = defineStore('store-name', {
    state: () => ({
        storage: useStorage('store-name-storage', {
            token: null,
        }, localStorage, {mergeDefaults: true}),
        alerts: {},
        confirms: {},
        modals: {}
    })
})
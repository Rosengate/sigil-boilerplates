import {main} from "@/stores/main";

export default {
    async alert(msg: string) {
        let id = Math.random() * 1000000;

        // @ts-ignore
        main().alerts[id] = {
            id: id,
            message: msg
        };
    },
    confirm(msg: string) {
        let confirm: any = null;

        var promise = new Promise((resolve, reject) => {
            let id = Math.random() + 1000000;

            // @ts-ignore
            confirm = main().confirms[id] = {
                id: id,
                message: msg,
                resolve: resolve,
                skipResolveOnCancel: false
            };
        });

        // @ts-ignore
        promise.now = function() {
            confirm.skipResolveOnCancel = true;

            return promise;
        }

        return promise;
    }
}
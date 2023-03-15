import {toast} from "bulma-toast";

export default {
    success(message: string) {
        toast({
            message: message,
            type: 'is-success',
            position: 'top-center'
        });
    },
    error(message: string, duration = 3000) {
        toast({
            message: message,
            type: 'is-danger',
            position: 'top-center',
            duration: duration
        })
    }
};
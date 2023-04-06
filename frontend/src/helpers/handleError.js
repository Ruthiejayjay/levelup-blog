import { useErrorStore } from '@/store/error'
import { notify } from "@kyvg/vue3-notification";

export default (errorResponse) => {
    const errorStore = useErrorStore()
    if (errorResponse.response?.status == 422) {
        errorStore.setErrors(errorResponse.response.data.errors)
        notify({ type: 'error', text: 'Please fix all validation errorrs' })
    } else if (errorResponse.response?.status === 403) {
        notify({ type: 'error', text: errorResponse.response.data.message })
    } else {
        notify({ type: 'error', text: 'Unexpected error occurred, please try again later.' })
    }
}
import Http from './Http'

export default {
    async getArticlesComments(articleSlug) {
        return await Http.get(`articles/${articleSlug}/comments`)
    },

    
    async addNewComment(articleSlug, formdata) {
        return await Http.post(`articles/${articleSlug}/comments`, formdata)
    },
}
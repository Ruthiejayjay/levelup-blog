import Http from './Http'

export default {
    async all() {
        return await Http.get('/categories')
    },
    async show(slug) {
        return await Http.get(`/categories/${slug}`)
    },
    async addNewCategory(formdata) {
        return await Http.post('/categories', formdata)
    },

    async handleUpdateCategory(slug, formdata) {
        return await Http.patch(`/categories/${slug}`, formdata)
    }

}
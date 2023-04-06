import Http from './Http'

export default {
    async all(orderBy = 'created_at', sortedBy = 'desc', perPage = 10, page = 1, categorySlug = null) {
        let query = `/articles?direction=${sortedBy}&ordering=${orderBy}&per_page=${perPage}&page=${page}`;

        if (categorySlug) {
            query += `&category=${categorySlug}`
        }

        return await Http.get(query);
    },

    async show(slug) {
        return await Http.get(`/articles/${slug}`)
    },
    async userArticlebyId(id) {
        return await Http.get(`/users/${id}/articles`)
    },

    async addNewArticle(formdata) {
        return await Http.post('/articles', formdata)
    },

    async addNewArticleWithImage(formdata) {
        const formData = new FormData()
        Object.keys(formdata).forEach(key => {
            if (key === 'categories_id') {

                formdata[key].forEach(
                    category => {
                        formData.append('categories_id[]', category)
                    }
                )
            } else {
                if (formdata[key] !== undefined) {
                    formData.append(key, formdata[key])
                }
            }
        })

        return await Http.post('/articles', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
    },

    async handleUpdateArticle(slug, formdata) {
        return await Http.patch(`/articles/${slug}`, formdata)
    },

    async handleUpdateArticleWithImage(slug, formdata) {
        const formData = new FormData()
        Object.keys(formdata).forEach(key => {
            if (key === 'categories_id') {

                formdata[key].forEach(
                    category => {
                        formData.append('categories_id[]', category)
                    }
                )
            } else {
                if (formdata[key] !== undefined) {
                    formData.append(key, formdata[key])
                }
            }
        })
        formData.append('_method', 'PATCH')

        return await Http.post(`/articles/${slug}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
    },

    removeCategory(slug, categoryId) {
        return Http.delete(`/articles/${slug}/category/${categoryId}`)
    },

}

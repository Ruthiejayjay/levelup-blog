import Http from './Http'

export default {
    async login(credentials) {
        return await Http.post('/authenticate', credentials)
    },

    async register(userDetails) {
        return await Http.post('/users', userDetails)
    },

    async me() {
        return await Http.get('/me')
    },

    async handleUpdateUserDetails(id, profileDetails) {
        return await Http.patch(`/users/${id}`, profileDetails)
    },

    async handleUpdateUserDetailsWithAvatar(id, avatar) {
        const formData = new FormData()
        formData.append('avatar', avatar)
        return await Http.post(`/users/${id}`, formData)
    }
}
export function login(credentials) {
    return new Promise((resolve, reject) => {
        axios.post('auth/login', credentials)
            .then(response => { resolve(response.data) })
            .catch(error => { reject(error.response.data) })
    })
}

export function getLocalUser() {
    const userStr = localStorage.getItem('user')

    if (!userStr) {
        return null
    }

    return JSON.parse(userStr)
}

export function logout() {
    return new Promise((resolve, reject) => {
        axios.post('auth/logout')
            .then(response => resolve(response))
            .catch(error => reject(error))
    })
}
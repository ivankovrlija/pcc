export function checkleads(user) {
    return new Promise((resolve, reject) => {
        axios.post('checklead', user)
            .then(response => { resolve(response.data) })
            .catch(error => { reject(error.response.data) })
    })
}

export function unsub(user) {
    return new Promise((resolve, reject) => {
        axios.post('unsubscribe_lead', user)
            .then(response => { resolve(response.data) })
            .catch(error => { reject(error.response.data) })
    })
}
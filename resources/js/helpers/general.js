export function initialize(store, router) {
    router.beforeEach((to, from, next) => {
        const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
        const currentUser  = store.state.auth.currentUser
    
        if (requiresAuth && !currentUser) {
            next('/login')
        } else if (to.path === '/login' && currentUser) {
            next('/')
        } else {
            next()
        }
    })

    axios.interceptors.response.use(null, error => {
        if (error.response.status === 401) {
            store.commit('auth/LOGOUT')
            router.push('/')
        }
        
        return Promise.reject(error)
    })
}

export function openWindow (url, title, options = {}) {
    if (typeof url === 'object') {
        options = url
        url = ''
    }

    options = { url, title, width: 600, height: 720, ...options }

    const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screen.left
    const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screen.top
    const width = window.innerWidth || document.documentElement.clientWidth || window.screen.width
    const height = window.innerHeight || document.documentElement.clientHeight || window.screen.height

    options.left = ((width / 2) - (options.width / 2)) + dualScreenLeft
    options.top = ((height / 2) - (options.height / 2)) + dualScreenTop
    
    const optionsStr = Object.keys(options).reduce((acc, key) => {
        acc.push(`${key}=${options[key]}`)
        return acc
    }, []).join(',')

    const newWindow = window.open(url, title, optionsStr)
        if (window.focus) {
        newWindow.focus()
    }

    return newWindow
}

export const notifyOptions = {
    type: 'success',
    allow_dismiss: false,
    newest_on_top: false,
    mouse_over:  false,
    showProgressbar:  false,
    spacing: 10,
    timer: 2000,
    placement: {
        from: 'bottom', 
        align: 'right'
    },
    offset: {
        x: 30, 
        y: 30
    },
    delay: 1000,
    z_index: 10000,
    animate: {
        enter: 'animated fadeInUp',
        exit: 'animated fadeOutRight'
    }
}

export function validateForm(id) {
    const $form     = $(`#${id}`)
    const validator = $form.validate()
    let valid       = true

    $form.find('input, select, textarea').each((i, element) => {
        if (!validator.element(element)) {
            valid = false
        }
    })

    return valid;
}
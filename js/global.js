const App = {
    data() {
        return {
            locale: 'ru',
            modals: {
                changer: false,
                wb: false,
                ozon: false,
                sber: false,
                ym: false,
                dg: false
            },
            formRules: {
                wb: {
                    name: [{required: true, message: 'Введите наименование', trigger: 'blur'}],
                    token: [{required: true, message: 'Введите токен', trigger: 'blur'}],
                    account_id: [{required: true, message: 'Выберите акканут', trigger: 'change'}]
                },
                ozon: {
                    name: [{required: true, message: 'Введите наименование', trigger: 'blur'}],
                    token: [{required: true, message: 'Введите токен', trigger: 'blur'}],
                    clientId: [{required: true, message: 'Введите Client-ID', trigger: 'blur'}],
                    account_id: [{required: true, message: 'Выберите акканут', trigger: 'change'}]
                },
                sber: {
                    name: [{required: true, message: 'Введите наименование', trigger: 'blur'}],
                    token: [{required: true, message: 'Введите токен', trigger: 'blur'}],
                    id: [{required: true, message: 'Введите ID', trigger: 'blur'}],
                    account_id: [{required: true, message: 'Выберите акканут', trigger: 'change'}]
                },
                ym: {
                    name: [{required: true, message: 'Введите наименование', trigger: 'blur'}],
                    account_id: [{required: true, message: 'Выберите акканут', trigger: 'change'}]
                },
                dg: {
                    name: [{required: true, message: 'Введите наименование', trigger: 'blur'}],
                    token: [{required: true, message: 'Введите токен', trigger: 'blur'}],
                    partner_id: [{required: true, message: 'Введите Partner ID', trigger: 'blur'}]
                }
            },
            models: {
                wb: {
                    name: '',
                    token: '',
                    orderPreText: '',
                    active: false,
                    account_id: null
                },
                ozon: {
                    name: '',
                    token: '',
                    clientId: '',
                    orderPreText: '',
                    active: false,
                    account_id: null
                },
                sber: {
                    name: '',
                    token: '',
                    id: '',
                    orderPreText: '',
                    active: false,
                    account_id: null
                },
                ym: {
                    name: '',
                    orderPreText: '',
                    active: false,
                    account_id: null
                },
                dg: {
                    name: '',
                    active: false,
                    token: '',
                    partner_id: '',
                }
            },
            places: null,
            accounts: null,
        }
    },
    methods: {
        getPlaces(){

        },
        getAccounts(){
            fetch('/api/?method=get&&type=accounts')
            .then(response => response.json())
            .then(response => {
                this.accounts = response
            })
        },
        addWb(){
            this.closeChanger()
            this.models.wb = {
                name: '',
                token: '',
                orderPreText: '',
                active: false
            }
            this.modals.wb = true
        },
        addOzon(){
            this.closeChanger()
            this.models.ozon = {
                name: '',
                token: '',
                clientId: '',
                orderPreText: '',
                active: false
            }
            this.modals.ozon = true
        },
        addSber(){
            this.closeChanger()
            this.models.sber = {
                name: '',
                token: '',
                id: '',
                orderPreText: '',
                active: false
            }
            this.modals.sber = true
        },
        addYm(){
            this.closeChanger()
            this.models.ym = {
                name: '',
                orderPreText: '',
                active: false
            }
            this.modals.ym = true
        },
        addDg(){
            this.models.dg = {
                name: '',
                active: false,
                token: '',
                partner_id: ''
            }
            this.modals.dg = true
        },
        openChanger(){
            this.modals.changer = true
        },
        closeChanger(){
            this.modals.changer = false
        },
        closeModals(){
            this.modals.wb = false
            this.modals.ozon = false
            this.modals.sber = false
            this.modals.ym = false
            this.modals.dg = false
        },
        async createWb(){
            await this.$refs['wbForm'].validate((valid, fields) => {
                if (valid) {
                    console.log('submit!')
                } else {
                    console.log('error submit!', fields)
                }
            })
        },
        async createOzon(){
            await this.$refs['ozonForm'].validate((valid, fields) => {
                if (valid) {
                    console.log('submit!')
                } else {
                    console.log('error submit!', fields)
                }
            })
        },
        async createSber(){
            await this.$refs['sberForm'].validate((valid, fields) => {
                if (valid) {
                    console.log('submit!')
                } else {
                    console.log('error submit!', fields)
                }
            })
        },
        async createYm(){
            await this.$refs['ymForm'].validate((valid, fields) => {
                if (valid) {
                    console.log('submit!')
                } else {
                    console.log('error submit!', fields)
                }
            })
        },
        async createDg(){
            await this.$refs['dgForm'].validate((valid, fields) => {
                if (valid) {
                    fetch('/api/?method=create&type=dg', {
                        method: 'post',
                        headers: {  
                            "Content-type": "application/json; charset=UTF-8"  
                            },
                        body: JSON.stringify(this.models.dg)
                    })
                    .then(response => response.json())
                    .then(response => {
                        if(response.status == 'ok')
                        this.modals.dg = false
                        this.getAccounts();
                    })
                    
                } else {
                    console.log('error submit!', fields)
                }
            })
        },
    },
    mounted(){
        // fetch places
        this.getPlaces()
        this.getAccounts()
    }
}

Vue.createApp(App).use(ElementPlus, {
    // size: 'small'
    locale: 'ru'
}).mount('#app')
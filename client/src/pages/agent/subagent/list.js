import {myTools} from '../index.js'
import MyVuetable from '../../../components/MyVuetable.vue'
import FilterBar from '../../../components/MyFilterBar.vue'
import TableActions from './components/TableActions.vue'
import DetailRow from './components/DetailRow.vue'
import MyToastr from '../../../components/MyToastr.vue'

Vue.component('table-actions', TableActions)
Vue.component('detail-row', DetailRow)

new Vue({
  el: '#app',
  components: {
    FilterBar,
    MyVuetable,
    MyToastr,
  },
  data: {
    eventHub: new Vue(),
    agentType: {
      2: '总代',
      3: '钻石',
      4: '金牌',
    },
    topUpData: {
      type: {
        1: '房卡',
        2: '金币',
      },
      typeId: 1,
      amount: null,
    },
    activatedRow: {
      group: '',
      parent: '',
      topUpType: 1,
      password: false,
    },                 //待编辑的行
    topUpApiPrefix: '/agent/api/top-up/child',
    editInfoApiPrefix: '/agent/api/subagent',
    deleteApiPrefix: '/agent/api/subagent',

    tableUrl: '/agent/api/subagent',
    tableFields: [
      // {
      //   name: 'id',
      //   title: 'ID',
      //   sortField: 'id',
      // },
      {
        name: 'name',
        title: '昵称',
      },
      // {
      //   name: 'account',
      //   title: '账号',
      //   sortField: 'account',
      // },
      {
        name: 'group.name',
        title: '级别',
        sortField: 'group_id',
      },
      // {
      //   name: 'parent.account',
      //   title: '上级',
      // },
      {
        name: 'inventorys',
        title: '房卡',
        callback: 'getCardsCount',
      },
      // {
      //   name: 'inventorys',
      //   title: '金币',
      //   callback: 'getCoinsCount',
      // },
      // {
      //   name: 'item_sold_total',
      //   title: '累计售卡',
      //   callback: 'getCardSoldTotal',
      // },
      {
        name: 'valid_card_consumed_num',
        title: '有效耗卡',
      },
      {
        name: '__component:table-actions',
        title: '操作',
        titleClass: 'text-center',
        dataClass: 'text-center',
      },
    ],
    callbacks: {
      getCardsCount (inventorys) {
        if (0 === inventorys.length) {
          return null
        }
        for (let inventory of inventorys) {
          if (inventory.item.name === '房卡') {
            return inventory.stock
          }
        }
      },
      getCoinsCount (inventorys) {
        if (0 === inventorys.length) {
          return null
        }
        for (let inventory of inventorys) {
          if (inventory.item.name === '金币') {
            return inventory.stock
          }
        }
      },
      getCardSoldTotal (v) {
        let cardTypeId = 1
        return v[cardTypeId] ? v[cardTypeId] : 0
      },
    },
  },

  methods: {
    topUpChild () {
      let _self = this
      let toastr = this.$refs.toastr
      let api = `${_self.topUpApiPrefix}/${_self.activatedRow.account}/${_self.topUpData.typeId}/${_self.topUpData.amount}`

      myTools.axiosInstance.post(api)
        .then(function (res) {
          myTools.msgResolver(res, toastr)
          _self.topUpData.amount = null
        })
        .catch(function (err) {
          alert(err)
        })
    },

    editChildInfo () {
      let _self = this
      let api = `${_self.editInfoApiPrefix}/${_self.activatedRow.id}`
      let toastr = this.$refs.toastr
      let data = _self.activatedRow.password ? _self.activatedRow
        : _.omit(_self.activatedRow, 'password')

      myTools.axiosInstance.put(api, data)
        .then(function (res) {
          myTools.msgResolver(res, toastr)

        })
        .catch(function (err) {
          alert(err)
        })
    },

    deleteAgent () {
      let _self = this
      let toastr = this.$refs.toastr
      let api = `${_self.deleteApiPrefix}/${_self.activatedRow.id}`

      myTools.axiosInstance.delete(api)
        .then(function (res) {
          myTools.msgResolver(res, toastr)

          //删除完成用户之后重新刷新表格数据，避免被删除用户继续留存在表格中
          _self.$root.eventHub.$emit('MyVuetable:refresh')
        })
        .catch(function (err) {
          alert(err)
        })
    },
  },

  mounted: function () {
    let _self = this
    this.$root.eventHub.$on('topUpChildEvent', (data) => _self.activatedRow = data)
    this.$root.eventHub.$on('editInfoEvent', (data) => _self.activatedRow = data)
    this.$root.eventHub.$on('deleteAgentEvent', (data) => _self.activatedRow = data)
  },
})

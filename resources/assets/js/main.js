import Vue from 'vue'
import WorkSelect from './components/work-select.vue'
import FlowtypeSelect from './components/flowtype-select.vue'
import UnitSelect from './components/unit-select.vue'
import WorkflowSelect from './components/workflow-select.vue'
import WorkflowNodes from './components/workflow-nodes.vue'

new Vue({
    el: 'body',
    components: {
        WorkSelect,
        WorkflowNodes,
        FlowtypeSelect,
        UnitSelect,
        WorkflowSelect
    }
})

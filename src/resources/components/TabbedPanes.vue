<script>
import Tab from './Tab.vue';
import Pane from './Pane.vue';
import LineChartPanel from './LineChartPanel.vue';

import styles from '../css/common.css';

export default {
  name: 'tabbed-panes',
  components: {
    Tab,
    Pane,
    LineChartPanel,
  },
  data() {
    return {
      activeIndex: null,
      tabComponents: [],
    };
  },
  mounted() {
    this.$nextTick(function() {
      if (!this.activeIndex) {
        this.selectTabAtIndex(0);
      }
    });

    this.getTabs();
  },
  methods: {
    getTabs() {
      const slotChildren = this.$slots.default;

      // limit to items with tags
      const tabSlots = slotChildren.filter(function(child) {
        return child.tag !== undefined;
      });

      let tabComponents = [];

      tabSlots.forEach(function(tabSlot) {
        if (tabSlot.componentInstance) {
          tabComponents.push(tabSlot.componentInstance);
        }
      });

      this.tabComponents = tabComponents;

      return this.tabComponents;
    },
    selectTabAtIndex(targetIndex) {
      //console.log(`selectTabAtIndex(${targetIndex})`);
      const self = this;

      this.tabComponents.forEach(function(tab, index) {
        tab.active = index === targetIndex;
      });

      this.activeIndex = targetIndex;
    },
  },
};
</script>

<template>
  <div v-cloak class="w-full h-full flex-col" style="display: flex">
    <div class="commerce-reports-tabbed-panes">
      <div class="tabs layout-flex w-full">
        <div
          v-for="(tab, index) in this.tabComponents"
          :key="tab.title"
          class="commerce-reports-tab"
          :class="{ 'bg-white active': tab.active, 'bg-soft-white': ! tab.active }"
          @click="selectTabAtIndex(index)"
        >
          <h3 class="m-0 p-0">{{ tab.title }}</h3>
          <div
            class="commerce-reports-trend m-0 p-0"
            :class="{ 'up': tab.positiveTrend, 'down': ! tab.positiveTrend }">{{ tab.trend }}
          </div>
        </div>
      </div>
    </div>
    <pane flush-top center-vertically class="flex-grow mb-6">
      <slot></slot>
    </pane>
  </div>
</template>

<style>
.commerce-reports-tab {
  flex: 1 1 0%;
  cursor: pointer;
  user-select: none;
  text-align: center;
  padding-top: 0.75rem;
  padding-bottom: 0.75rem;
  padding-left: 1rem;
  padding-right: 1rem;
  border: 1px solid #e3e5e8;
  border-left-color: transparent;
  border-collapse: collapse;
}

.commerce-reports-tab:first-child {
  border-top-left-radius: 0.25rem;
  border-left-color: #e3e5e8;
}

.commerce-reports-tab:last-child {
  border-top-right-radius: 0.25rem;
}

.commerce-reports-tab.active {
  border-bottom-color: transparent;
}

.commerce-reports-tab-pane {
  @apply rounded-b;
  border: 1px solid #e3e5e8;
  border-top: 0;
}
</style>

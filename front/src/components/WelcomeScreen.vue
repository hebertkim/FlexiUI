<template>
    <div>
        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog class="relative z-50 lg:hidden" @close="sidebarOpen = false">
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300"
                    enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300"
                    leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-900/80" />
                </TransitionChild>

                <div class="fixed inset-0 flex">
                    <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                        enter-from="-translate-x-full" enter-to="translate-x-0"
                        leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                        leave-to="-translate-x-full">
                        <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
                            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
                                enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100"
                                leave-to="opacity-0">
                                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                                    <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                                        <span class="sr-only">Close sidebar</span>
                                        <XMarkIcon class="size-6 text-white" aria-hidden="true" />
                                    </button>
                                </div>
                            </TransitionChild>
                            <!-- Sidebar component -->
                            <div
                                class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 pb-4 ring-1 ring-white/10">
                                <div class="flex h-16 shrink-0 items-center">
                                    <img class="h-8 w-auto"
                                        src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=500"
                                        alt="FlexUI" />
                                </div>
                                <nav class="flex flex-1 flex-col">
                                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                        <li>
                                            <ul role="list" class="-mx-2 space-y-1">
                                                <li v-for="item in navigation" :key="item.name">
                                                    <RouterLink :to="item.href"
                                                        :class="[item.current ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white', 'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold']"
                                                        @click="toggleSubmenu(item)">
                                                        <component :is="item.icon" class="size-6 shrink-0"
                                                            aria-hidden="true" />
                                                        {{ item.name }}
                                                    </RouterLink>
                                                    <ul v-if="item.submenu && item.isOpen" class="pl-4 space-y-2">
                                                        <li v-for="subitem in item.submenu" :key="subitem.name">
                                                            <RouterLink :to="subitem.href"
                                                                :class="'text-gray-400 hover:bg-gray-800 hover:text-white group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold'">
                                                                {{ subitem.name }}
                                                            </RouterLink>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="mt-auto">
                                            <RouterLink to="#"
                                                class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-400 hover:bg-gray-800 hover:text-white">
                                                <Cog6ToothIcon class="size-6 shrink-0" aria-hidden="true" />
                                                Settings
                                            </RouterLink>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
            <!-- Sidebar component -->
            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900/20 backdrop-blur-lg px-6 pb-4">
                <div class="flex h-16 mt-6 shrink-0 items-center">
                    <img class="w-16 h-16 mb-3 mx-auto rounded-full shadow-md" src="../assets/logo.jpeg "
                        alt="Controllytics Pro" />
                </div>
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <li v-for="item in navigation" :key="item.name">
                                    <RouterLink :to="item.href" :class="[item.current ? 'bg-gray-800 text-white' : 'text-gray-500 hover:bg-gray-800 hover:text-white',
                                        'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold']"
                                        @click="toggleSubmenu(item)">
                                        <component :is="item.icon" class="size-6 shrink-0" aria-hidden="true" />
                                        {{ item.name }}
                                    </RouterLink>
                                    <ul v-if="item.submenu && item.isOpen" class="pl-4 space-y-2">
                                        <li v-for="subitem in item.submenu" :key="subitem.name">
                                            <RouterLink :to="subitem.href"
                                                :class="'text-gray-500 hover:bg-gray-800 hover:text-white group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold'">
                                                {{ subitem.name }}
                                            </RouterLink>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="lg:pl-72">
            <div
                class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span>
                    <Bars3Icon class="size-6" aria-hidden="true" />
                </button>

                <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true" />

                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                    <form class="grid flex-1 grid-cols-1" action="#" method="GET">
                        <input type="search" name="search" aria-label="Search"
                            class="col-start-1 row-start-1 block size-full bg-white pl-8 text-base text-gray-900 outline-none placeholder:text-gray-400 sm:text-sm/6"
                            placeholder="Search" />
                        <MagnifyingGlassIcon
                            class="pointer-events-none col-start-1 row-start-1 size-5 self-center text-gray-400"
                            aria-hidden="true" />
                    </form>
                    <div class="flex items-center gap-x-4 lg:gap-x-6">
                        <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
                            <span class="sr-only">View notifications</span>
                            <BellIcon class="size-6" aria-hidden="true" />
                        </button>

                        <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-900/10" aria-hidden="true" />

                        <Menu as="div" class="relative">
                            <MenuButton class="-m-1.5 flex items-center p-1.5">
                                <img class="size-8 rounded-full bg-gray-50"
                                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    alt="" />
                                <span class="hidden lg:flex lg:items-center">
                                    <span class="ml-4 text-sm/6 font-semibold text-gray-900" aria-hidden="true">{{
                                        userName }}</span>
                                </span>
                            </MenuButton>
                            <transition enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95">
                                <MenuItems
                                    class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
                                    <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                    <a :href="item.href"
                                        :class="[active ? 'bg-gray-50 outline-none' : '', 'block px-3 py-1 text-sm/6 text-gray-900']"
                                        @click.prevent="handleLogout">{{ item.name }}</a>
                                    </MenuItem>
                                </MenuItems>
                            </transition>
                        </Menu>

                        <a href="#" class="flex items-center text-gray-400 hover:text-gray-500"
                            @click.prevent="handleLogout">
                            <ArrowRightOnRectangleIcon class="size-6" aria-hidden="true" />
                        </a>
                    </div>
                </div>
            </div>

            <main class="py-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    <router-view />
                </div>
            </main>

        </div>
    </div>
</template>

<script setup>
import { ref, computed, reactive } from 'vue'
import { useRouter, RouterLink } from 'vue-router'
import {
    Dialog,
    DialogPanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import {
    Bars3Icon,
    BellIcon,
    CalendarIcon,
    Cog6ToothIcon,
    HomeIcon,
    UsersIcon,
    XMarkIcon,
    CurrencyDollarIcon,
    ShieldExclamationIcon,
    ArrowRightOnRectangleIcon,
} from '@heroicons/vue/24/outline'
import { MagnifyingGlassIcon } from '@heroicons/vue/20/solid'

const navigation = reactive([
    {
        name: 'Dashboard', href: '#', icon: HomeIcon, current: true, isOpen: false,
        submenu: [
            { name: 'Overview', href: '/overview', icon: UsersIcon },
            { name: 'Performance Analysis', href: '/overview/trends', icon: CalendarIcon },
            { name: 'Alerts and Notifications', href: '/overview/alerts', icon: BellIcon },
            { name: 'Quick Reports', href: '/overview/quick-actions', icon: CurrencyDollarIcon }
        ]
    },
    {
        name: 'Registration', href: '#', icon: UsersIcon, current: false, isOpen: false,
        submenu: [
            { name: 'Customer Registration', href: '#', icon: UsersIcon },
            { name: 'Supplier Registration', href: '#', icon: UsersIcon },
            { name: 'Employee Registration', href: '#', icon: UsersIcon },
            { name: 'Bank Accounts Registration', href: '#', icon: CurrencyDollarIcon },
            { name: 'Cost Center Registration', href: '#', icon: CurrencyDollarIcon }
        ]
    },
    {
        name: 'Finance', href: '#', icon: CurrencyDollarIcon, current: false, isOpen: false,
        submenu: [
            { name: 'Accounts Payable', href: '#', icon: CurrencyDollarIcon },
            { name: 'Accounts Receivable', href: '#', icon: CurrencyDollarIcon },
            { name: 'Cash Flow', href: '#', icon: CurrencyDollarIcon },
            { name: 'Financial Reports', href: '#', icon: CurrencyDollarIcon }
        ]
    },
    {
        name: 'Budget and Planning', href: '#', icon: CalendarIcon, current: false, isOpen: false,
        submenu: [
            { name: 'Annual Budget', href: '#', icon: CalendarIcon },
            { name: 'Forecasts and Projections', href: '#', icon: CalendarIcon },
            { name: 'Deviation Analysis', href: '#', icon: CalendarIcon }
        ]
    },
    {
        name: 'Cost Control', href: '#', icon: CurrencyDollarIcon, current: false, isOpen: false,
        submenu: [
            { name: 'Fixed Costs', href: '#', icon: CurrencyDollarIcon },
            { name: 'Variable Costs', href: '#', icon: CurrencyDollarIcon },
            { name: 'Cost Analysis', href: '#', icon: CurrencyDollarIcon }
        ]
    },
    {
        name: 'Risks and Compliance', href: '#', icon: ShieldExclamationIcon, current: false, isOpen: false,
        submenu: [
            { name: 'Risk Management', href: '#', icon: ShieldExclamationIcon },
            { name: 'Compliance', href: '#', icon: ShieldExclamationIcon },
            { name: 'Internal Audit', href: '#', icon: ShieldExclamationIcon }
        ]
    },
    {
        name: 'Settings', href: '#', icon: Cog6ToothIcon, current: false, isOpen: false,
        submenu: [
            { name: 'Users', href: '/settings/users', icon: UsersIcon },
            { name: 'Preferences', href: '/settings/preferences', icon: Cog6ToothIcon },
            { name: 'Access Control', href: '/settings/access', icon: ShieldExclamationIcon },
            { name: 'Database Settings', href: '/settings/database', icon: Cog6ToothIcon },
            { name: 'Connect Database', href: '/settings/erp-connect', icon: Cog6ToothIcon }
        ]
    }

])

const sidebarOpen = ref(false)

const userName = computed(() => {
    return localStorage.getItem('userName') || 'Guest'
})

const router = useRouter()

function toggleSubmenu(item) {
    if (item.submenu) {
        navigation.forEach(i => {
            if (i !== item) {
                i.isOpen = false
            }
        })
        item.isOpen = !item.isOpen
    }
}

function handleLogout() {
    router.push('/login')
}
</script>

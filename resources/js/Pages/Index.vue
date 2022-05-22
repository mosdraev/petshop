<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue'
import DatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { createToaster } from "@meforma/vue-toaster";

const toaster = createToaster();

const datepickerFormat = 'MM/dd/yyyy';
const date = ref();

let flashData = '';
let selectedDays = [];
let selectedTimes = [];
let frequency = 'recurring';
let notes = '';
let formData = {};
let showFlash = false;

const onSelectFrequency = (check) => {
    let items = document.getElementsByClassName('fo-item');
    for (let item of items) {
        item.classList.remove("active-option");
    }
    frequency = check
    document.getElementById(check).classList.add("active-option");
}

const handleDate = (modelData) => {
    date.value = modelData;
}

const updateNotes = (modelData) => {
    notes = modelData
}

const removeItem = (item, array) => {
    let i = array.indexOf(item);
    if (i !== -1) {
        array.splice(i, 1);
    }
}

const onSelectTime = (item) => {
    let element = document.getElementById(item);
    if (element.classList.contains("active-option")) {
        element.classList.remove("active-option");
        removeItem(item, selectedTimes);
    }
    else {
        element.classList.add("active-option");
        selectedTimes.push(item);
    }
}

const onSelectDay = (item) => {
    let element = document.getElementById(item);
    if (element.classList.contains("active-option")) {
        element.classList.remove("active-option");
        removeItem(item, selectedDays);
    }
    else {
        element.classList.add("active-option");
        selectedDays.push(item);
    }
}

const form = useForm({
    day: '',
    time: '',
    note: '',
    date: '',
    frequency: ''
});

const onSubmitForm = () => {
    form.day = selectedDays;
    form.time = selectedTimes;
    form.note = notes;
    form.date = date.value;
    form.frequency = frequency;
}

const removeSelections = () => {
    let items = document.getElementsByClassName('day-item');
    for (let item of items) {
        item.classList.remove("active-option");
    }
    items = document.getElementsByClassName('time-item');
    for (let item of items) {
        item.classList.remove("active-option");
    }
}

const submit = () => {
    form.post(route('schedule'), {
        preserveScroll: true,
        onSuccess: (data) => {
            flashData = data
            showFlash = true
            toaster.success(data.props.flash.content.message, {
                position: 'top'
            })
        },
        onError: (data) => {
            console.log(data);
        },
        onFinish: (data) => {
            onSelectFrequency('recurring');
            removeSelections();
            date.value = '';
            selectedDays = [];
            selectedTimes = [];
            updateNotes('this is the default');
            form.note = '';
        },
    });
};

</script>

<template>
    <Head title="Welcome" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <div class="hero-bg">
        <div class="hero-bg-layer">
            <!--Nav-->
            <nav id="header" class="w-full z-30 top-0 text-white py-1 lg:py-6">
                <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-2 lg:py-6">
                    <div class="pl-4 flex items-center">
                        <div><img class="pet-logo" src="../../images/logo/paw.png"></div>
                        <a class="text-white no-underline hover:no-underline font-bold text-2xl lg:text-4xl" href="#">
                            PAWTASTIC
                        </a>
                    </div>
                    <div class="w-full flex-grow lg:flex lg:items-center lg:w-auto hidden lg:block mt-2 lg:mt-0 text-gray p-4 lg:p-0 z-20" id="nav-content">
                        <ul class="list-reset lg:flex justify-end flex-1 items-center">
                            <li class="mr-3">
                                <a class="inline-block text-white no-underline hover:text-gray-800 hover:text-underline text-2xl py-2 px-4" href="#services">About Us</a>
                            </li>
                            <li class="mr-3">
                                <a class="inline-block text-white no-underline hover:text-gray-800 hover:text-underline text-2xl py-2 px-4" href="#appointments">Schedule a visit</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="flex flex-row-reverse">
                <div class="hero-tag-line text-gray-800">
                    <p class="">
                        We care for <br/> your furry little <br/> love ones
                    </p>
                    <a href="#appointments" class="appointment-white mx-auto lg:mx-0 text-gray-800 rounded-full my-2 md:my-6 py-4 px-8 w-48 bg-white">Schedule a visit</a>
                </div>
            </div>
        </div>
    </div>

    <section id="services" class="">
        <div class="container services-container max-w-5xl">
            <div class="flex flex-wrap">
                <div class="services-container w-5/6 sm:w-1/2 p-6">
                    <p class="services-tagline text-6xl text-gray-800 font-bold leading-none mb-3">
                        Expert care for your furry, feathery, or scaley friend
                    </p>
                    <p class="services-description text-xl text-gray-600 mb-8 pt-4">
                        We know how stressfull to leave your pets at home alone.
                        Were a team of experienced animal caregivers, well connected to local veterinarians.
                        Trust us to love them like our own and to keep them safe and happy till you're home.
                    </p>
                    <a href="#appointments" class="mx-auto lg:mx-0 text-white rounded-full my-2 md:my-6 py-4 px-8 w-48 bg-gray-800">Schedule a visit</a>
                </div>
                <div class="w-full sm:w-1/2 p-6">
                    <div class="pet-grid">
                        <div class="pet-tiles">
                            <img src="../../images/cat.jpg" />
                        </div>
                        <div class="pet-tiles">
                            <img src="../../images/parrot.jpg" class="h-full" />
                        </div>
                    </div>
                    <div class="pet-grid mt-2.5">
                        <div class="pet-tiles">
                            <img src="../../images/dog.jpg" />
                        </div>
                        <div class="pet-tiles">
                            <img src="../../images/hamster.jpg" class="h-full" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="appointments" class="bg-gray-100 border-b">
        <div class="container max-w-full">
            <div class="flex flex-wrap">
                <div class="services-bg w-5/6 sm:w-1/2">
                    <div class="services-bg-layer">
                        <div class="services-text-container">
                            <div class="appointment-options pl-4 pt-20 flex items-center">
                                <div><a href="#"><img class="pet-logo" src="../../images/logo/paw.png"></a></div>
                                <a class="text-white no-underline hover:no-underline font-bold text-2xl lg:text-4xl" href="#">
                                    PAWTASTIC
                                </a>
                            </div>
                            <div class="appointment-services pt-20">
                                <p class="services-title">All services include:</p>
                                <ul class="list-disc services-list">
                                    <li>A photo update with your pet</li>
                                    <li>Notifications of sitter arrival</li>
                                    <li>Treats for your pet</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="appointments-bg w-full sm:w-1/2 p-6">
                    <div class="appointments-container">
                        <p class="appointments-title">We'll take your dog for a walk. Just tell us when!</p>
                        <form id="appointment_form" @submit.prevent="submit" class="pt-8">
                            <div class="flex">
                                <div class="frequency">
                                    <label class="pb-1">Frequency</label>
                                    <ul class="flex frequency-option">
                                        <li class="flex-1">
                                            <a id="recurring" @click="onSelectFrequency('recurring')" class="fo-item text-center block active-option bg-white py-1 px-2 text-gray-800">Recurring</a>
                                        </li>
                                        <li class="flex-1">
                                            <a id="one-time" @click="onSelectFrequency('one-time')" class="fo-item text-center block bg-white py-1 px-2 text-gray-800">One Time</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="w-3/6">
                                    <label class="pb-1">Start Date</label>
                                    <DatePicker
                                        v-model="date"
                                        placeholder="MM/DD/YYYY" class="shadow appointments-datepicker w-full text-gray-700 leading-tight"
                                        :format="datepickerFormat"
                                        :min-date='new Date()'
                                        :enableTimePicker="false"
                                        @update:modelValue="handleDate"
                                        selectText="Select Date"
                                        cancelText="Close"
                                        disableMonthYearSelect
                                    />
                                </div>
                            </div>
                            <div class="pt-4">
                                <label class="pb-1"><span class="font-bold">Days</span> Select all that apply</label>
                                <ul class="flex day-items">
                                    <li class="flex-1">
                                        <a id="mon" @click="onSelectDay('mon')" class="day-item text-center block bg-white py-2 px-4 text-gray-800">Mon</a>
                                    </li>
                                    <li class="flex-1">
                                        <a id="tue" @click="onSelectDay('tue')" class="day-item text-center block bg-white py-2 px-4 text-gray-800">Tue</a>
                                    </li>
                                    <li class="flex-1">
                                        <a id="wed" @click="onSelectDay('wed')" class="day-item text-center block bg-white py-2 px-4 text-gray-800">Wed</a>
                                    </li>
                                    <li class="flex-1">
                                        <a id="thu" @click="onSelectDay('thu')" class="day-item text-center block bg-white py-2 px-4 text-gray-800">Thu</a>
                                    </li>
                                    <li class="flex-1">
                                        <a id="fri" @click="onSelectDay('fri')" class="day-item text-center block bg-white py-2 px-4 text-gray-800">Fri</a>
                                    </li>
                                    <li class="flex-1">
                                        <a id="sat" @click="onSelectDay('sat')" class="day-item text-center block bg-white py-2 px-4 text-gray-800">Sat</a>
                                    </li>
                                    <li class="flex-1">
                                        <a id="sun" @click="onSelectDay('sun')" class="day-item text-center block bg-white py-2 px-4 text-gray-800">Sun</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="pt-4">
                                <label class="pb-1"><span class="font-bold">Times</span> Select all that apply</label>
                                <ul class="flex time-items">
                                    <li class="flex-1">
                                        <a id="morning" @click="onSelectTime('morning')" class="time-item text-center block bg-white py-2 px-4 text-gray-800">Morning</a>
                                    </li>
                                    <li class="flex-1">
                                        <a id="afternoon" @click="onSelectTime('afternoon')" class="time-item text-center block bg-white py-2 px-4 text-gray-800">Afternoon</a>
                                    </li>
                                    <li class="flex-1">
                                        <a id="evening" @click="onSelectTime('evening')" class="time-item text-center block bg-white py-2 px-4 text-gray-800">Evening</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="pt-4">
                                <label class="pb-1">Notes for your sitter</label>
                                <textarea
                                    id="pet-notes"
                                    placeholder="Route preferences, Search location, treats given, etc."
                                    cols="70"
                                    rows="5"
                                    class="
                                        form-control
                                        block
                                        w-full
                                        px-3
                                        py-1.5
                                        text-base
                                        font-normal
                                        text-gray-700
                                        bg-white bg-clip-padding
                                        border border-solid border-gray-300
                                        rounded
                                        transition
                                        ease-in-out
                                        m-0
                                        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
                                    "
                                    v-model="form.note"
                                    @keyup="updateNotes(form.note)"
                                ></textarea>
                            </div>

                            <div class="appointments-button">
                                <button type="submit"
                                    class="mx-auto lg:mx-0 text-white rounded-full my-2 md:my-6 py-2 px-8 w-48 bg-gray-800"
                                    @click="onSubmitForm"
                                >Schedule Service</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>

</style>

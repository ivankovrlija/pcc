<template>
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

        <Subheader :title="`Course`" :separator="true">
            <template v-slot:content>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total">Enter course details and submit</span>
                </div>
            </template>
            <template v-slot:toolbar>
                <ButtonBack />
                <div class="btn-group">
                    <button type="button" class="btn btn-brand btn-bold" :class="{'kt-spinner kt-spinner--right kt-spinner--light': loading}" @click="handleSubmit" :disabled="loading">Update</button>
                    <button type="button" class="btn btn-brand btn-bold dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" :disabled="loading"></button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <ul class="kt-nav">
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link" @click.prevent="handleSubmit('continue')">
                                    <i class="kt-nav__link-icon flaticon2-writing"></i>
                                    <span class="kt-nav__link-text">Update &amp; continue</span>
                                </a>
                            </li>
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link" @click.prevent="handleSubmit('exit')">
                                    <i class="kt-nav__link-icon flaticon2-hourglass-1"></i>
                                    <span class="kt-nav__link-text">Update &amp; exit</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </template>
        </Subheader>

        <div id="kt_content" class="kt-content kt-grid__item kt-grid__item--fluid">            
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <form class="kt-form" id="kt_apps_user_add_lead_form" novalidate="novalidate">
                        <div class="row">
                            <div class="col-md-6 divider">
                                <h3>Course Information</h3>
                                <br>
                            	<div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="name" class="col-form-label">Name:</label>
                                        <input v-model="course.name" type="text" name="name" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="type" class="col-form-label">Type:</label>
                                        <select v-model="course.type" name="type" class="form-control">
                                            <option value="internal">Internal</option>
                                            <option value="external">External</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="year" class="col-form-label">Year:</label>
                                        <select v-model="course.year" name="year" class="form-control">
                                            <option value="1999">1999</option>
                                            <option value="2000">2000</option>
                                            <option value="2001">2001</option>
                                            <option value="2002">2002</option>
                                            <option value="2003">2003</option>
                                            <option value="2004">2004</option>
                                            <option value="2005">2005</option>
                                            <option value="2006">2006</option>
                                            <option value="2007">2007</option>
                                            <option value="2008">2008</option>
                                            <option value="2009">2009</option>
                                            <option value="2010">2010</option>
                                            <option value="2011">2011</option>
                                            <option value="2012">2012</option>
                                            <option value="2013">2013</option>
                                            <option value="2014">2014</option>
                                            <option value="2015">2015</option>
                                            <option value="2016">2016</option>
                                            <option value="2017">2017</option>
                                            <option value="2018">2018</option>
                                            <option value="2019">2019</option>
                                            <option value="2020">2020</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="number_of_employees" class="col-form-label">Number Of Employees:</label>
                                        <select v-model="course.number_of_employees" name="number_of_employees" class="form-control">
                                                    <option value="1">1</option>

                                                    <option value="2">2</option>

                                                    <option value="3">3</option>

                                                    <option value="4">4</option>

                                                    <option value="5">5</option>

                                                    <option value="6">6</option>

                                                    <option value="7">7</option>

                                                    <option value="8">8</option>

                                                    <option value="9">9</option>

                                                    <option value="10">10</option>

                                                    <option value="11">11</option>

                                                    <option value="12">12</option>

                                                    <option value="13">13</option>

                                                    <option value="14">14</option>

                                                    <option value="15">15</option>

                                                    <option value="16">16</option>

                                                    <option value="17">17</option>

                                                    <option value="18">18</option>

                                                    <option value="19">19</option>

                                                    <option value="20">20</option>

                                                    <option value="21">21</option>

                                                    <option value="22">22</option>

                                                    <option value="23">23</option>

                                                    <option value="24">24</option>

                                                    <option value="25">25</option>

                                                    <option value="26">26</option>

                                                    <option value="27">27</option>

                                                    <option value="28">28</option>

                                                    <option value="29">29</option>

                                                    <option value="30">30</option>

                                                    <option value="31">31</option>

                                                    <option value="32">32</option>

                                                    <option value="33">33</option>

                                                    <option value="34">34</option>

                                                    <option value="35">35</option>

                                                    <option value="36">36</option>

                                                    <option value="37">37</option>

                                                    <option value="38">38</option>

                                                    <option value="39">39</option>

                                                    <option value="40">40</option>

                                                    <option value="41">41</option>

                                                    <option value="42">42</option>

                                                    <option value="43">43</option>

                                                    <option value="44">44</option>

                                                    <option value="45">45</option>

                                                    <option value="46">46</option>

                                                    <option value="47">47</option>

                                                    <option value="48">48</option>

                                                    <option value="49">49</option>

                                                    <option value="50">50</option>

                                                    <option value="51">51</option>

                                                    <option value="52">52</option>

                                                    <option value="53">53</option>

                                                    <option value="54">54</option>

                                                    <option value="55">55</option>

                                                    <option value="56">56</option>

                                                    <option value="57">57</option>

                                                    <option value="58">58</option>

                                                    <option value="59">59</option>

                                                    <option value="60">60</option>

                                                    <option value="61">61</option>

                                                    <option value="62">62</option>

                                                    <option value="63">63</option>

                                                    <option value="64">64</option>

                                                    <option value="65">65</option>

                                                    <option value="66">66</option>

                                                    <option value="67">67</option>

                                                    <option value="68">68</option>

                                                    <option value="69">69</option>

                                                    <option value="70">70</option>

                                                    <option value="71">71</option>

                                                    <option value="72">72</option>

                                                    <option value="73">73</option>

                                                    <option value="74">74</option>

                                                    <option value="75">75</option>

                                                    <option value="76">76</option>

                                                    <option value="77">77</option>

                                                    <option value="78">78</option>

                                                    <option value="79">79</option>

                                                    <option value="80">80</option>

                                                    <option value="81">81</option>

                                                    <option value="82">82</option>

                                                    <option value="83">83</option>

                                                    <option value="84">84</option>

                                                    <option value="85">85</option>

                                                    <option value="86">86</option>

                                                    <option value="87">87</option>

                                                    <option value="88">88</option>

                                                    <option value="89">89</option>

                                                    <option value="90">90</option>

                                                    <option value="91">91</option>

                                                    <option value="92">92</option>

                                                    <option value="93">93</option>

                                                    <option value="94">94</option>

                                                    <option value="95">95</option>

                                                    <option value="96">96</option>

                                                    <option value="97">97</option>

                                                    <option value="98">98</option>

                                                    <option value="99">99</option>

                                                    <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label for="details" class="col-form-label">Details:</label>
                                        <textarea v-model="course.details" rows="10" name="details" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h3>Course Realization</h3>
                                <br>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="number_of_employees" class="col-form-label">Number Of Employees:</label>
                                        <select v-model="course.realized_number_of_employees" name="number_of_employees" class="form-control">
                                                    <option value="1">1</option>

                                                    <option value="2">2</option>

                                                    <option value="3">3</option>

                                                    <option value="4">4</option>

                                                    <option value="5">5</option>

                                                    <option value="6">6</option>

                                                    <option value="7">7</option>

                                                    <option value="8">8</option>

                                                    <option value="9">9</option>

                                                    <option value="10">10</option>

                                                    <option value="11">11</option>

                                                    <option value="12">12</option>

                                                    <option value="13">13</option>

                                                    <option value="14">14</option>

                                                    <option value="15">15</option>

                                                    <option value="16">16</option>

                                                    <option value="17">17</option>

                                                    <option value="18">18</option>

                                                    <option value="19">19</option>

                                                    <option value="20">20</option>

                                                    <option value="21">21</option>

                                                    <option value="22">22</option>

                                                    <option value="23">23</option>

                                                    <option value="24">24</option>

                                                    <option value="25">25</option>

                                                    <option value="26">26</option>

                                                    <option value="27">27</option>

                                                    <option value="28">28</option>

                                                    <option value="29">29</option>

                                                    <option value="30">30</option>

                                                    <option value="31">31</option>

                                                    <option value="32">32</option>

                                                    <option value="33">33</option>

                                                    <option value="34">34</option>

                                                    <option value="35">35</option>

                                                    <option value="36">36</option>

                                                    <option value="37">37</option>

                                                    <option value="38">38</option>

                                                    <option value="39">39</option>

                                                    <option value="40">40</option>

                                                    <option value="41">41</option>

                                                    <option value="42">42</option>

                                                    <option value="43">43</option>

                                                    <option value="44">44</option>

                                                    <option value="45">45</option>

                                                    <option value="46">46</option>

                                                    <option value="47">47</option>

                                                    <option value="48">48</option>

                                                    <option value="49">49</option>

                                                    <option value="50">50</option>

                                                    <option value="51">51</option>

                                                    <option value="52">52</option>

                                                    <option value="53">53</option>

                                                    <option value="54">54</option>

                                                    <option value="55">55</option>

                                                    <option value="56">56</option>

                                                    <option value="57">57</option>

                                                    <option value="58">58</option>

                                                    <option value="59">59</option>

                                                    <option value="60">60</option>

                                                    <option value="61">61</option>

                                                    <option value="62">62</option>

                                                    <option value="63">63</option>

                                                    <option value="64">64</option>

                                                    <option value="65">65</option>

                                                    <option value="66">66</option>

                                                    <option value="67">67</option>

                                                    <option value="68">68</option>

                                                    <option value="69">69</option>

                                                    <option value="70">70</option>

                                                    <option value="71">71</option>

                                                    <option value="72">72</option>

                                                    <option value="73">73</option>

                                                    <option value="74">74</option>

                                                    <option value="75">75</option>

                                                    <option value="76">76</option>

                                                    <option value="77">77</option>

                                                    <option value="78">78</option>

                                                    <option value="79">79</option>

                                                    <option value="80">80</option>

                                                    <option value="81">81</option>

                                                    <option value="82">82</option>

                                                    <option value="83">83</option>

                                                    <option value="84">84</option>

                                                    <option value="85">85</option>

                                                    <option value="86">86</option>

                                                    <option value="87">87</option>

                                                    <option value="88">88</option>

                                                    <option value="89">89</option>

                                                    <option value="90">90</option>

                                                    <option value="91">91</option>

                                                    <option value="92">92</option>

                                                    <option value="93">93</option>

                                                    <option value="94">94</option>

                                                    <option value="95">95</option>

                                                    <option value="96">96</option>

                                                    <option value="97">97</option>

                                                    <option value="98">98</option>

                                                    <option value="99">99</option>

                                                    <option value="100">100</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="realized_rates" class="col-form-label">Rates:</label>
                                        <select v-model="course.realized_rates" name="realized_rates" class="form-control">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Subheader from '../../../includes/Subheader'
import ButtonBack from '../../../components/ButtonBack'

export default {
    name: 'CourseUpdate',
    components: {
        Subheader,
        ButtonBack
    },
    data() {
        return {
            course_id: null,
            form: null,
            course: {
                name                           : '',
                type                           : '',
                year                           : '',
                number_of_employees            : '',
                details                        : '',
                realized_number_of_employees   : '',
                realized_rates                 : ''
            },
            errors: null,
            notify: null,
            loading: false
        }
    },
    computed: {
        currentUser() {
            return this.$store.getters['auth/currentUser']
        }
    },
    mounted() {
        this.fetchCourse()
    },
    methods:{
        fetchCourse() {
            this.$http.get(`courses/${this.$route.params.id}`)
                .then(response => {
                    this.course_id = response.data.id
                    this.course = {
                        name        : response.data.name,
                        type       : response.data.type,
                        year     : response.data.year,
                        number_of_employees     : response.data.number_of_employees,
                        realized_number_of_employees      : response.data.realized_number_of_employees,
                        realized_rates          : response.data.realized_rates,
                        details          : response.data.details
                    }
                })
                .catch(error => {
                    if (error.response.status === 404) {
                        this.$router.push({ path: 'user/not-found' })
                    }
                })
        },
        validation() {
            this.form = $( "#kt_apps_user_add_lead_form" ).validate({
                rules: {
                    first_name: { required: true },
                    last_name: { required: true },
                    phone: { digits: true },
                    email: {
                        required: true,
                        email: true
                    }
                }
            })

            this.form.form()
        },
        notification(type, content) {
            if (this.notify) {
                this.notify.update('type', type)
                this.notify.update('title', content.title)
                this.notify.update('message', content.message)
            }

            this.notify = $.notify(content, { 
                type: type,
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
            });
        },
        resetModels() {
            this.course.name                         = ''
            this.course.type                         = ''
            this.course.year                         = ''
            this.course.number_of_employees          = ''
            this.course.details                      = ''
            this.course.realized_number_of_employees = ''
            this.course.realized_rates               = ''
        },
        handleSubmit(proceed = 'default') {
            this.validation();

            this.loading = true

            if (!this.form.valid()) {
                this.loading = false
                return
            }


            this.course.name = this.course.name
            this.course.type = this.course.type
            this.course.year = this.course.year
            this.course.number_of_employees = this.course.number_of_employees
            this.course.details = this.course.details
            this.course.realized_number_of_employees = this.course.realized_number_of_employees
            this.course.realized_rates = this.course.realized_rates

            this.$http.put(`courses/${this.$route.params.id}`, this.course)
                .then(response => {

                    this.loading = false
                    //console.log(response.data.status)
                    //console.log(data)
                    if (response.data.status === 'success') {
                        const type    = 'success'
                        const content = {
                            title  : 'Course data has been updated',
                            message: `${this.course.name}'s info has been updated`
                        }
                        if (typeof proceed !== 'string') {
                            this.notification(type, content)
                        } else {
                            if (proceed === 'continue') {
                                this.notification(type, content)
                            }
                            else if (proceed === 'new') {
                                this.notification(type, content)
                                this.resetModels()
                            }
                            else if (proceed === 'exit') {
                                this.$router.push({ path: '/guests' })
                            }
                        }

                    }
                })
                .catch(error => {
                    this.loading = false
                    this.errors = Object.values(error.response.data.errors);
                    this.errors = this.errors.flat()

                    const content = {
                        title: error.response.data.message,
                        message: this.errors.map(function(error) {
                            return `<li>${error}</li>`
                        }).join('')
                    }

                    this.notification('danger', content)
                })
        }
    }
}
</script>


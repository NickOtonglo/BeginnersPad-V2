<template>
    <h3 class="section-title">System</h3>
    <section id="sectionTable">
        <div class="container">
            <table class="horizontal-scroll">
                <tr class="single-column">
                    <th>Commands (use with caution)</th>
                </tr>
                <!-- <template> -->
                    <tr class="single-column">
                        <th>Command</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr class="single-column">
                        <td>Reset system</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <a id="linkLeave" 
                               href="#"
                               @click.prevent="click(enterPasswordRef)">
                                reset
                            </a>
                        </td>
                    </tr>
                <!-- </template> -->
            </table>
            <table class="horizontal-scroll">
                <tr class="single-column">
                    <th>Controls</th>
                </tr>
                <!-- <template> -->
                    <tr class="single-column">
                        <th>Key</th>
                        <th></th>
                        <th></th>
                        <th>Value</th>
                        <th></th>
                    </tr>
                    <!-- <template class="form-group"> -->
                        <tr class="single-column">
                            <td>name_of_key</td>
                            <td></td>
                            <td></td>
                            <td>false</td>
                            <td>
                                <a id="linkLeave" 
                                   href="#"
                                   @click.prevent="">
                                    change
                                </a>
                            </td>
                        </tr>
                    <!-- </template> -->
                <!-- </template> -->
            </table>
        </div>
    </section>

    <section id="sectionTable">
        <div class="container">
            <div class="table-grp">
                <h4 class="table-title">System log</h4>
                <table>
                    <tr>
                        <th>#</th>
                        <th>Key</th>
                        <th>Value</th>
                        <th>Action</th>
                        <th>Comments</th>
                        <th>Time</th>
                    </tr>
                    <!-- <template> -->
                        <tr>
                            <td>0</td>
                            <td>key</td>
                            <td>value</td>
                            <td>action</td>
                            <td>comment</td>
                            <td>00-00-0000 00:00:00</td>
                        </tr>
                    <!-- </template> -->
                </table>
            </div>
        </div>
    </section>

    <EnterPassword @secret-check="confirmSecret" ref="enterPasswordRef" />
</template>

<script setup>
import { onBeforeUpdate, ref } from 'vue';
import userMaster from '../../composables/users';
import systemMaster from '../../composables/system';
import EnterPassword from '../Modals/EnterPassword.vue';

const enterPasswordRef = ref(null)

const {
    route, 
} = userMaster()
const {
    resetSys, 
} = systemMaster()

function confirmSecret(status) {
    if (status = 201) {
        click(enterPasswordRef.value)
        resetSys()
    }
}

function click(element) {
    element.openModal();
}

onBeforeUpdate(() => {
    document.title = route.meta.name+' | '+localStorage.getItem('title')
})
</script>
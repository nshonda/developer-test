<template>
    <Page>
        <div class="text-center pt-10 flex flex-row">
            <div class="w-1/2">
                <div class="text-sm font-bold">
                    Current Balance<br>
                    <span class="text-2xl font-bold">$ {{ balance }}</span>
                </div>
            </div>
            <div class="w-1/2">
                <el-date-picker v-model="date" type="month" placeholder="Pick a month" format="MMMM, YYYY" @calendar-change="handleChangedMonth"></el-date-picker>
            </div>
        </div>
    </Page>
</template>

<script>
import {defineComponent, computed, ref} from 'vue';
import {trans} from "@/helpers/i18n";
import {useAuthStore} from "@/stores/auth";
import { ElDatePicker } from 'element-plus'
import Page from "@/views/layouts/Page";

export default defineComponent({

    components: {
        Page,
        ElDatePicker
    },
    setup() {
        const { user } = useAuthStore();
        const balance = computed(() => {
            const num = user?.balance ?? 0;
            return (Math.round(num * 100) / 100).toFixed(2);
        });
        const date = ref(new Date());
        const handleChangedMonth = (date) => {
            console.log(date);
        }
        return {
            trans,
            balance,
            date,
            handleChangedMonth
        }
    }
});
</script>

<style scoped>
.el-input {
    width: 100%;
    background: none;
}
</style>

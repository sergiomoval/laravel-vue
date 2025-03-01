<script setup lang="ts">
import {
  Card,
  CardContent,
  CardFooter,
  CardHeader,
} from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { onMounted } from 'vue'
import { Button } from '@/components/ui/button'
import { useForm } from '@inertiajs/vue3'

const props = defineProps<{
    user: any,
    roles: any
}>();

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    rol: null,
});

onMounted(() => {
    form.name = props.user.name;
    form.email = props.user.email;
    form.rol = props.user.roles[0].name;
});


const edit = () => form.put(route('administration.users.update', props.user.id));

</script>

<template>
    <Card class="w-full max-w-md">
        <CardHeader></CardHeader>
        <form @submit.prevent="edit">
            <CardContent>
                <div class="grid items-center w-full gap-4">
                    <div class="flex flex-col space-y-1.5">
                        <Label for="name"> {{ $t('Name') }}</Label>
                        <Input 
                            id="name" 
                            name="name" 
                            v-model="form.name"
                            required
                        />
                        <div v-if="form.errors.name" class="text-[0.8rem] font-medium text-destructive">
                            {{ form.errors.name }}
                        </div>
                    </div>
                    <div class="flex flex-col space-y-1.5">
                        <Label for="email"> {{ $t('Email Address') }}</Label>
                        <Input 
                            id="email" 
                            name="email" 
                            v-model="form.email"
                            required
                        />
                        <div v-if="form.errors.email" class="text-[0.8rem] font-medium text-destructive">
                            {{ form.errors.email }}
                        </div>
                    </div>
                    <div class="flex flex-col space-y-1.5">
                        <Label for="password"> {{ $t('Password') }}</Label>
                        <Input type="password" id="password" name="password" v-model="form.password"/>
                        <div v-if="form.errors.password" class="text-[0.8rem] font-medium text-destructive">
                            {{ form.errors.password }}
                        </div>
                    </div>
                    <div class="flex flex-col space-y-1.5">
                        <Label for="password_confirmation"> {{ $t('Re-Type Password') }}</Label>
                        <Input type="password" id="password_confirmation" name="password_confirmation" v-model="form.password_confirmation"/>
                    </div>
                    <div class="flex flex-col space-y-1.5">
                        <Label for="role">Rol</Label>
                        <Select v-model="form.rol">
                            <SelectTrigger id="role">
                                <SelectValue :placeholder="$t('Select')" />
                            </SelectTrigger>
                            <SelectContent position="popper">
                                <SelectItem v-for="rol in props.roles" :key="rol.id" :value="rol.name">
                                {{ rol.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                </div>
            </CardContent>
            <CardFooter class="flex justify-between px-6 pb-6">
                <Button type="submit" >{{ $t('Create') }}</Button>
            </CardFooter>
        </form>
    </Card>
</template>
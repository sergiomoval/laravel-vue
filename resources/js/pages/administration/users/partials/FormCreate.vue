<script setup lang="ts">
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
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
import { Button } from '@/components/ui/button'
import { useForm } from '@inertiajs/vue3';
import { Footprints } from 'lucide-vue-next'

const props = defineProps<{
    roles: any;
}>();

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    rol: null,
    locale: null,
});
const register = () => form.post(route('administration.users.store'));

</script>

<template>
    <Card class="w-full">
        <CardHeader></CardHeader>
        <form @submit.prevent="register">
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
                    <div class="flex flex-col space-y-1.5">
                        <Label for="role">{{ $t('Language') }}</Label>
                        <Select defaultValue="es" v-model="form.locale">
                            <SelectTrigger id="locale">
                                <SelectValue :placeholder="$t('Select')" />
                            </SelectTrigger>
                            <SelectContent position="popper">
                                <SelectItem value="es">{{ $t('Spanish') }}</SelectItem>
                                <SelectItem value="en">{{ $t('English') }}</SelectItem>
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
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
import { Button } from '@/components/ui/button'
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    roles: any;
}>();

const form = useForm({
    name: null,
    email: null,
    role: null,
    locale: null,
})
const invite = () => form.post(route('administration.users.invite'));

</script>

<template>
    <Card class="w-full">
        <CardHeader></CardHeader>
        <form @submit.prevent="invite">
            <CardContent>
                <div class="grid items-center w-full gap-4">
                    <div class="flex flex-col space-y-1.5">
                        <Label for="name"> {{ $t('Name') }}</Label>
                        <Input id="name" name="name" v-model="form.name"/>
                        <div v-if="form.errors.name" class="text-[0.8rem] font-medium text-destructive">
                            {{ form.errors.name }}
                        </div>
                    </div>
                    <div class="flex flex-col space-y-1.5">
                        <Label for="email"> {{ $t('Email Address') }}</Label>
                        <Input id="email" name="email" v-model="form.email"/>
                        <div v-if="form.errors.email" class="text-[0.8rem] font-medium text-destructive">
                            {{ form.errors.email }}
                        </div>
                    </div>
                    <div class="flex flex-col space-y-1.5">
                        <Label for="role">Rol</Label>
                        <Select v-model="form.role">
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
                <Button type="submit" >{{ $t('Invite') }}</Button>
            </CardFooter>
        </form>
    </Card>
</template>
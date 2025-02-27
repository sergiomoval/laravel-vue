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

const props = defineProps<{
    roles: any;
}>();

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    rol: null,
});

</script>

<template>
    <Card class="w-full max-w-md">
        <CardHeader>
            <CardTitle>Create project</CardTitle>
            <CardDescription>Deploy your new project in one-click.</CardDescription>
        </CardHeader>
        <CardContent>
            <form>
                <div class="grid items-center w-full gap-4">
                    <div class="flex flex-col space-y-1.5">
                        <Label for="name"> {{ $t('Name') }}</Label>
                        <Input id="name"/>
                    </div>
                    <div class="flex flex-col space-y-1.5">
                        <Label for="name"> {{ $t('Email Address') }}</Label>
                        <Input id="name"/>
                    </div>
                    <div class="flex flex-col space-y-1.5">
                        <Label for="name"> {{ $t('Password') }}</Label>
                        <Input id="name"/>
                    </div>
                    <div class="flex flex-col space-y-1.5">
                        <Label for="name"> {{ $t('') }}</Label>
                        <Input id="name"/>
                    </div>
                    <div class="flex flex-col space-y-1.5">
                        <Label for="framework">Rol</Label>
                        <Select>
                        <SelectTrigger id="framework">
                            <SelectValue :placeholder="$t('Select')" />
                        </SelectTrigger>
                        <SelectContent position="popper">
                            <SelectItem v-for="rol in props.roles" :key="rol.id" :value="rol.id">
                            {{ rol.name }}
                            </SelectItem>
                        </SelectContent>
                        </Select>
                    </div>
                </div>
            </form>
        </CardContent>
        <CardFooter class="flex justify-between px-6 pb-6">
            <Button >{{ $t('Create') }}</Button>
        </CardFooter>
    </Card>
</template>
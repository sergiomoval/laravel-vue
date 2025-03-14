<script setup lang="ts">
import {
  AlertDialog,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from '@/components/ui/alert-dialog'
import {
  Card,
  CardContent
} from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { useForm} from '@inertiajs/vue3'

const props = defineProps<{
    user: any
    action: string
}>();

const form = useForm({
    _type: props.action
});

const formDelete = () => form.delete(route('administration.users.destroy', props.user.id));
</script>

<template>

<Card class="w-full">
    <CardContent>
        <div class="flex justify-center mt-10 mb-6">
            
            <AlertDialog>
                <AlertDialogTrigger asChild>
                    <Button v-if="props.action == 'DELETE'"  variant="destructive">{{ $t('Delete :object', { object: $t('User') }) }}</Button>
                    <Button v-else >{{ $t('Restore :object', { object: $t('User') }) }}</Button>
                </AlertDialogTrigger>
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>{{ $t('Are you sure?') }}</AlertDialogTitle>
                        <AlertDialogDescription v-if="props.action == 'DELETE'">
                            {{ $t('The user will be denied access to the platform') }}.
                        </AlertDialogDescription>
                        <AlertDialogDescription v-if="props.action == 'RESTORE'">
                            {{ $t('The user will be granted access to the platform') }}.
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel>{{ $t('Cancel') }}</AlertDialogCancel>
                        <form @submit.prevent="formDelete">
                            <Button v-if="props.action == 'DELETE'" type="submit" variant="destructive">{{ $t('Delete') }}</Button>
                            <Button v-else type="submit">{{ $t('Restore') }}</Button>
                        </form>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        
        </div>
        
    </CardContent>
</Card>
</template>
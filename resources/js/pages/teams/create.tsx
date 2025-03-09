import HeadingSmall from '@/components/heading-small';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import TeamsLayout from '@/layouts/teams/layout';
import { BreadcrumbItem, Permission, PermissionGroup } from '@/types';
import { Transition } from '@headlessui/react';
import { Head, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

type TeamForm = {
    name: string;
    description: string;
    permissions: string[];
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Teams settings',
        href: '/teams',
    },
    {
        title: 'Create team',
        href: '/teams/create',
    },
];

export default function Create({ permissionGroups }: { permissionGroups: PermissionGroup[] }) {
    const { data, setData, post, processing, errors, recentlySuccessful } = useForm<TeamForm>({
        name: '',
        description: '',
        permissions: [],
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('teams.store'));
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Teams settings" />

            <TeamsLayout>
                <div className="space-y-6">
                    <HeadingSmall title="Create a team" description="Create a new team to manage users and permissions" />

                    <form onSubmit={submit} className="space-y-6">
                        <div className="grid gap-2">
                            <Label htmlFor="name">Name</Label>
                            <Input
                                id="name"
                                type="text"
                                required
                                autoFocus
                                autoComplete="name"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                disabled={processing}
                                placeholder="Full name"
                            />
                            <InputError message={errors.name} className="mt-2" />
                        </div>
                        <div className="grid gap-2">
                            <Label htmlFor="description">Description</Label>
                            <Input
                                id="description"
                                type="text"
                                autoComplete="description"
                                value={data.description}
                                onChange={(e) => setData('description', e.target.value)}
                                disabled={processing}
                                placeholder="Description"
                            />
                            <InputError message={errors.description} className="mt-2" />
                        </div>
                        {/*<pre>{JSON.stringify(data.permissions, null, 2)}</pre>*/}
                        <fieldset className="space-y-4">
                            <legend className="text-base">Permissions</legend>
                            <InputError message={errors.permissions} className="mt-2" />
                            <div className="space-y-8">
                                <div className="flex items-center">
                                    <Checkbox id="selectAll" />
                                    <label htmlFor="selectAll" className="ml-2 text-sm font-semibold">
                                        Select All Permissions
                                    </label>
                                </div>
                                {permissionGroups.map((group: PermissionGroup) => (
                                    <div key={group.value} className="space-y-4">
                                        <div className="flex items-center">
                                            <Checkbox id={`selectGroup-${group.value}`} />
                                            <label htmlFor={`selectGroup-${group.value}`}
                                                   className="ml-2 text-sm font-semibold">
                                                {group.label}
                                            </label>
                                        </div>

                                        <div className="space-y-2">
                                            {group.permissions.map((permission: Permission) => (
                                                <div key={permission.value} className="relative flex items-start">
                                                    <div className="flex h-6 items-center">
                                                        <Checkbox
                                                            id={permission.value}
                                                            value={permission.value}
                                                            checked={data.permissions.includes(permission.value)}
                                                            onCheckedChange={(checked) => {
                                                                if (checked) {
                                                                    setData('permissions', [...data.permissions, permission.value]);
                                                                } else {
                                                                    setData(
                                                                        'permissions',
                                                                        data.permissions.filter((p) => p !== permission.value),
                                                                    );
                                                                }
                                                            }}
                                                        />
                                                    </div>
                                                    <div className="ml-3 text-sm leading-6">
                                                        <label htmlFor={permission.value}
                                                               className="font-medium text-gray-900 dark:text-white">
                                                            {permission.label}
                                                        </label>{' '}
                                                        <span
                                                            className="text-gray-500 dark:text-gray-400">{permission.description}</span>
                                                    </div>
                                                </div>
                                            ))}
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </fieldset>

                        <div className="flex items-center gap-4">
                            <Button disabled={processing}>Save</Button>

                            <Transition
                                show={recentlySuccessful}
                                enter="transition ease-in-out"
                                enterFrom="opacity-0"
                                leave="transition ease-in-out"
                                leaveTo="opacity-0"
                            >
                                <p className="text-sm text-neutral-600">Saved</p>
                            </Transition>
                        </div>
                    </form>
                </div>
            </TeamsLayout>
        </AppLayout>
    );
}

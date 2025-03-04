import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AuthLayout from '@/layouts/auth-layout';
import { Head, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { FormEventHandler } from 'react';
import { brazilianStates } from '@/constants/brazilian-states';

type SubscribeForm = {
    name: string;
    acronym?: string;
    email: string;
    foundation_date: string;
    password: string;
    password_confirmation: string;
    state: string;
    city: string;
};

export default function Subscribe() {
    const { data, setData, post, processing, errors, reset } = useForm<SubscribeForm>({
        name: 'São João do Cariri',
        acronym: 'SJC',
        email: 'saojoao.cariri@gmail.com',
        foundation_date: '2023-01-01',
        password: 'P@ssw0rd!2025',
        password_confirmation: 'P@ssw0rd!2025',
        state: 'CE',
        city: 'Juazeiro do Norte',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('subscribe'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <AuthLayout title="Create an account" description="Enter your details below to create your account">
            <Head title="Subscribe" />
            <form className="flex flex-col gap-6" onSubmit={submit}>
                <div className="grid gap-6">
                    <div className="grid gap-2">
                        <Label htmlFor="name">Name</Label>
                        <Input
                            id="name"
                            type="text"
                            required
                            autoFocus
                            tabIndex={1}
                            autoComplete="name"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            disabled={processing}
                            placeholder="Full name"
                        />
                        <InputError message={errors.name} className="mt-2" />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="acronym">Acronym</Label>
                        <Input
                            id="acronym"
                            type="text"
                            tabIndex={2}
                            autoComplete="acronym"
                            value={data.acronym}
                            onChange={(e) => setData('acronym', e.target.value)}
                            disabled={processing}
                            placeholder="Acronym"
                        />
                        <InputError message={errors.acronym} className="mt-2" />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="email">Email address</Label>
                        <Input
                            id="email"
                            type="email"
                            required
                            tabIndex={3}
                            autoComplete="email"
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                            disabled={processing}
                            placeholder="email@example.com"
                        />
                        <InputError message={errors.email} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="foundation_date">Foundation date</Label>
                        <Input
                            id="foundation_date"
                            type="date"
                            required
                            tabIndex={4}
                            autoComplete="foundation_date"
                            value={data.foundation_date}
                            onChange={(e) => setData('foundation_date', e.target.value)}
                            disabled={processing}
                        />
                        <InputError message={errors.foundation_date} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="password">Password</Label>
                        <Input
                            id="password"
                            type="password"
                            required
                            tabIndex={5}
                            autoComplete="new-password"
                            value={data.password}
                            onChange={(e) => setData('password', e.target.value)}
                            disabled={processing}
                            placeholder="Password"
                        />
                        <InputError message={errors.password} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="password_confirmation">Confirm password</Label>
                        <Input
                            id="password_confirmation"
                            type="password"
                            required
                            tabIndex={6}
                            autoComplete="new-password"
                            value={data.password_confirmation}
                            onChange={(e) => setData('password_confirmation', e.target.value)}
                            disabled={processing}
                            placeholder="Confirm password"
                        />
                        <InputError message={errors.password_confirmation} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="state">State</Label>
                        <Select
                            value={data.state}
                            onValueChange={(value) => setData('state', value)}
                        >
                            <SelectTrigger name="state" tabIndex={7} disabled={processing}>
                                <SelectValue placeholder="Select a state" />
                            </SelectTrigger>
                            <SelectContent>
                                {brazilianStates.map((state) => (
                                    <SelectItem key={state.abbreviation} value={state.abbreviation}>
                                        {state.name}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        <InputError message={errors.state} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="city">City</Label>
                        <Input
                            id="city"
                            type="text"
                            required
                            tabIndex={8}
                            autoComplete="city"
                            value={data.city}
                            onChange={(e) => setData('city', e.target.value)}
                            disabled={processing}
                            placeholder="City"
                        />
                        <InputError message={errors.city} className="mt-2" />
                    </div>

                    <Button type="submit" className="mt-2 w-full" tabIndex={9} disabled={processing}>
                        {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                        Create account
                    </Button>
                </div>

                <div className="text-muted-foreground text-center text-sm">
                    Already have an account?{' '}
                    <TextLink href={route('login')} tabIndex={10}>
                        Log in
                    </TextLink>
                </div>
            </form>
        </AuthLayout>
    );
}

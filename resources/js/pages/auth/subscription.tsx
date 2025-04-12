import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AuthLayout from '@/layouts/auth-layout';
import { Head, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import type { FormEventHandler } from 'react';

type SubscriptionForm = {
    plan: string;
    tenant: {
        name: string;
        email: string;
        foundation_date: string;
        state: string;
        city: string;
    };
    owner: {
        name: string;
        email: string;
        password: string;
        password_confirmation: string;
    };
};

type Plan = {
    type: string;
    title: string;
    description: string;
    price: number;
};

export default function Subscription() {
    const { data, setData, post, processing, errors } = useForm<Required<SubscriptionForm>>({
        plan: 'free',
        tenant: {
            name: '',
            email: '',
            foundation_date: '',
            state: '',
            city: '',
        },
        owner: {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        },
    });

    const plans: Plan[] = [
        {
            type: 'free',
            title: 'Free',
            description: 'Ideal for small events.',
            price: 0,
        },
        {
            type: 'pro',
            title: 'Pro',
            description: 'Ideal for large events.',
            price: 10,
        },
    ];

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('subscription.store'), {
            preserveScroll: true,
            onFinish: () =>
                setData('owner', {
                    ...data.owner,
                    password: '',
                    password_confirmation: '',
                }),
        });
    };

    return (
        <AuthLayout title="Choose Your Plan" description="Select the plan that best suits your needs">
            <Head title="Subscription Plans" />

            <form onSubmit={submit}>
                <div className="divide-primary-foreground flex flex-col gap-6 divide-y-2">
                    <div className="pb-6">
                        <RadioGroup value={data.plan} onValueChange={(value) => setData('plan', value)}>
                            {plans.map((plan) => (
                                <div key={plan.type}>
                                    <RadioGroupItem
                                        value={plan.type}
                                        id={`SelectItem-${plan.type}`}
                                        autoFocus
                                        tabIndex={0}
                                        className="peer sr-only"
                                    />
                                    <Label
                                        htmlFor={`SelectItem-${plan.type}`}
                                        className="peer-data-[state=checked]:border-primary flex h-full w-full cursor-pointer flex-col rounded-lg border-2 p-6"
                                    >
                                        <div className="flex items-center justify-between">
                                            <div className="flex flex-col">
                                                <span>{plan.title}</span>
                                                <span className="text-muted-foreground text-sm">{plan.description}</span>
                                            </div>
                                            <span className="mt-auto text-lg font-medium">
                                                {plan.price.toLocaleString('en-US', {
                                                    style: 'currency',
                                                    currency: 'USD',
                                                })}
                                            </span>
                                        </div>
                                    </Label>
                                </div>
                            ))}
                        </RadioGroup>
                        <InputError message={errors.plan} className="mt-2" />
                    </div>

                    <div className="grid gap-6 pt-6 pb-6">
                        <div>
                            <h2 className="text-primary text-base leading-7 font-semibold">Tenant Information</h2>
                            <p className="text-muted-foreground mt-1 text-sm">Please enter your tenant information.</p>
                            <InputError message={errors.tenant} className="mt-2" />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="tenant-name">Name</Label>
                            <Input
                                id="tenant-name"
                                type="text"
                                required
                                tabIndex={1}
                                autoComplete="name"
                                value={data.tenant.name}
                                onChange={(e) => setData('tenant', { ...data.tenant, name: e.target.value })}
                                placeholder="Tenant Name"
                            />
                            <InputError message={errors['tenant.name']} />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="tenant-email">Email address</Label>
                            <Input
                                id="tenant-email"
                                type="email"
                                required
                                tabIndex={2}
                                autoComplete="email"
                                value={data.tenant.email}
                                onChange={(e) => setData('tenant', { ...data.tenant, email: e.target.value })}
                                placeholder="email@example.com"
                            />
                            <InputError message={errors['tenant.email']} />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="tenant-foundation-date">Foundation date</Label>
                            <Input
                                id="tenant-foundation-date"
                                type="date"
                                required
                                tabIndex={3}
                                defaultValue={data.tenant.foundation_date}
                                onChange={(e) => setData('tenant', { ...data.tenant, foundation_date: e.target.value })}
                            />
                            <InputError message={errors['tenant.foundation_date']} />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="tenant-state">State</Label>
                            <Select value={data.tenant.state} onValueChange={(value) => setData('tenant', { ...data.tenant, state: value })}>
                                <SelectTrigger id="tenant-state" tabIndex={4}>
                                    <SelectValue placeholder="Select a state" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="AC">Acre</SelectItem>
                                    <SelectItem value="AL">Alagoas</SelectItem>
                                    <SelectItem value="AP">Amapá</SelectItem>
                                    <SelectItem value="AM">Amazonas</SelectItem>
                                    <SelectItem value="BA">Bahia</SelectItem>
                                    <SelectItem value="CE">Ceará</SelectItem>
                                    <SelectItem value="DF">Distrito Federal</SelectItem>
                                    <SelectItem value="ES">Espírito Santo</SelectItem>
                                    <SelectItem value="GO">Goiás</SelectItem>
                                    <SelectItem value="MA">Maranhão</SelectItem>
                                    <SelectItem value="MT">Mato Grosso</SelectItem>
                                    <SelectItem value="MS">Mato Grosso do Sul</SelectItem>
                                    <SelectItem value="MG">Minas Gerais</SelectItem>
                                    <SelectItem value="PA">Pará</SelectItem>
                                    <SelectItem value="PB">Paraíba</SelectItem>
                                    <SelectItem value="PR">Paraná</SelectItem>
                                    <SelectItem value="PE">Pernambuco</SelectItem>
                                    <SelectItem value="PI">Piauí</SelectItem>
                                    <SelectItem value="RJ">Rio de Janeiro</SelectItem>
                                    <SelectItem value="RN">Rio Grande do Norte</SelectItem>
                                    <SelectItem value="RS">Rio Grande do Sul</SelectItem>
                                    <SelectItem value="RO">Rondônia</SelectItem>
                                    <SelectItem value="RR">Roraima</SelectItem>
                                    <SelectItem value="SC">Santa Catarina</SelectItem>
                                    <SelectItem value="SP">São Paulo</SelectItem>
                                    <SelectItem value="SE">Sergipe</SelectItem>
                                    <SelectItem value="TO">Tocantins</SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError message={errors['tenant.state']} />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="tenant-city">City</Label>
                            <Input
                                id="tenant-city"
                                type="text"
                                required
                                autoComplete="city"
                                tabIndex={5}
                                value={data.tenant.city}
                                onChange={(e) => setData('tenant', { ...data.tenant, city: e.target.value })}
                                placeholder="City"
                            />
                            <InputError message={errors.tenant} />
                        </div>
                    </div>

                    <div className="grid gap-6 pt-6 pb-6">
                        <div>
                            <h2 className="text-primary text-base leading-7 font-semibold">Owner Information</h2>
                            <p className="text-muted-foreground mt-1 text-sm">Please enter your details.</p>
                            <InputError message={errors.owner} className="mt-2" />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="owner-name">Full name</Label>
                            <Input
                                id="owner-name"
                                type="text"
                                required
                                tabIndex={6}
                                autoComplete="name"
                                value={data.owner.name}
                                onChange={(e) => setData('owner', { ...data.owner, name: e.target.value })}
                                placeholder="John Doe"
                            />
                            <InputError message={errors['owner.name']} />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="owner-email">Email address</Label>
                            <Input
                                id="owner-email"
                                type="email"
                                required
                                tabIndex={7}
                                autoComplete="email"
                                value={data.owner.email}
                                onChange={(e) => setData('owner', { ...data.owner, email: e.target.value })}
                                placeholder="email@example.com"
                            />
                            <InputError message={errors['owner.email']} />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="owner-password">Password</Label>
                            <Input
                                id="owner-password"
                                type="password"
                                required
                                tabIndex={8}
                                value={data.owner.password}
                                onChange={(e) => setData('owner', { ...data.owner, password: e.target.value })}
                            />
                            <InputError message={errors['owner.password']} />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="owner-password-confirmation">Password confirmation</Label>
                            <Input
                                id="owner-password-confirmation"
                                type="password"
                                required
                                tabIndex={9}
                                value={data.owner.password_confirmation}
                                onChange={(e) =>
                                    setData('owner', {
                                        ...data.owner,
                                        password_confirmation: e.target.value,
                                    })
                                }
                            />
                            <InputError message={errors['owner.password_confirmation']} />
                        </div>
                    </div>
                </div>

                <Button type="submit" className="mt-4 w-full" tabIndex={10} disabled={processing}>
                    {processing && <LoaderCircle className="mr-2 h-4 w-4 animate-spin" />}
                    Subscribe
                </Button>
            </form>
        </AuthLayout>
    );
}

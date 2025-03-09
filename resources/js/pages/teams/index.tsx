import HeadingSmall from '@/components/heading-small';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import TeamsLayout from '@/layouts/teams/layout';
import type { BreadcrumbItem, Team } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { ChevronRight, ShieldCheck, Users } from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Teams settings',
        href: '/teams',
    },
];

export default function Index({ teams }: { teams: Team[] }) {
    const getTeamAvatarFallback = (name: string) => {
        const words = name.split(' ');
        if (words.length >= 2) {
            return `${words[0][0]}${words[1][0]}`.toUpperCase();
        }
        return name.substring(0, 2).toUpperCase();
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Teams settings" />

            <TeamsLayout>
                <div className="space-y-12">
                    <div className="flex items-center justify-between">
                        <HeadingSmall title="Manage teams" description="Manage and assign users to teams" />
                        <div>
                            <Link href={route('teams.create')}>
                                <Button>Create team</Button>
                            </Link>
                        </div>
                    </div>

                    <div className="divide-y divide-gray-100 dark:divide-gray-800">
                        {teams.map((team: Team) => (
                            <div key={team.id} className="hover:bg-muted/50 cursor-pointer py-4 transition-colors">
                                <div className="flex items-center gap-4">
                                    <Avatar className="h-12 w-12">
                                        <AvatarFallback className="bg-primary/10 text-primary">{getTeamAvatarFallback(team.name)}</AvatarFallback>
                                    </Avatar>

                                    <div className="min-w-0 flex-1">
                                        <h3 className="truncate text-base font-medium">{team.name}</h3>
                                        <p className="text-muted-foreground truncate text-sm">{team.description}</p>
                                    </div>

                                    <div className="flex items-center gap-4">
                                        <div className="flex items-center gap-1">
                                            <Users className="text-muted-foreground h-4 w-4" />
                                            <span className="text-muted-foreground text-sm">{team.members?.length} Members</span>
                                        </div>

                                        <div className="flex items-center gap-1">
                                            <ShieldCheck className="text-muted-foreground h-4 w-4" />
                                            <span className="text-muted-foreground text-sm">{team.permissions?.length} Permissions</span>
                                        </div>

                                        <ChevronRight className="text-muted-foreground h-5 w-5" />
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </TeamsLayout>
        </AppLayout>
    );
}

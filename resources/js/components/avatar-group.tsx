import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';

interface Member {
    id: string
    name: string
    image?: string
}

interface AvatarGroupProps {
    members: Member[]
    limit?: number
}

export function AvatarGroup({ members, limit = 4 }: AvatarGroupProps) {
    const visibleMembers = members.slice(0, limit)
    const remainingCount = Math.max(0, members.length - limit)

    const getInitials = (name: string) => {
        return name
            .split(" ")
            .map((part) => part[0])
            .join("")
            .toUpperCase()
            .substring(0, 2)
    }

    return (
        <div className="flex -space-x-2">
            {visibleMembers.map((member) => (
                <Avatar key={member.id} className="h-8 w-8 text-xs border-2 border-background rounded-full">
                    <AvatarImage src={member.image} alt={member.name} />
                    <AvatarFallback>{getInitials(member.name)}</AvatarFallback>
                </Avatar>
            ))}

            {remainingCount > 0 && (
                <div className="h-8 w-8 text-xs flex items-center justify-center rounded-full border-2 border-background text-foreground font-medium">
                    +{remainingCount}
                </div>
            )}
        </div>
    )
}

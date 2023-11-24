export interface Guild {
    id: number;
    name: string;
    recruiting: boolean;
    description: string;
    characters: Member[];
    invitations: Invitation[];
    is_leader: boolean;
    is_vice_leader: boolean;
}

export interface Member {
    id: number;
    name: string;
    nickname: string;
    vocation: string;
    role: string;
}

export interface Invitation {
    id: number;
    character: Character;
}

export interface Character {
    id: number;
    name: string;
    vocation: string;
}

export interface CharactersPagination {
    data: Character[];
    current_page: number;
    last_page: number;
}

export interface GuildInvitation {
    id: number;
    character: Character;
    guild: Guild;
    invited_at: string;
}
// Utilidades de autenticación compartidas entre páginas del frontend
const API_BASE = 'http://localhost/api'; // Cambia esto según tu configuración de backend
const TOKEN_KEY = 'kyng_token';
const USER_KEY = 'kyng_user';

export interface AuthUser {
  id: number;
  username: string;
  [key: string]: unknown;
}

export interface LoginResult {
  success: boolean;
  message: string;
  token?: string;
  user?: AuthUser;
}

export function apiUrl(route: string): string {
  return `${API_BASE}/${route}`;
}

export async function login(user: string, password: string): Promise<LoginResult> {
  const response = await fetch(apiUrl('login'), {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ user, password }),
  });

  console.log('Login response status:', response.status);

  const data = await response.json().catch(() => null);

  if (!data) {
    return { success: false, message: 'Respuesta inválida del servidor' };
  }

  return data as LoginResult;
}

export function saveSession(token: string, user: AuthUser): void {
  localStorage.setItem(TOKEN_KEY, token);
  localStorage.setItem(USER_KEY, JSON.stringify(user));
}

export function clearSession(): void {
  localStorage.removeItem(TOKEN_KEY);
  localStorage.removeItem(USER_KEY);
}

export function getToken(): string | null {
  return localStorage.getItem(TOKEN_KEY);
}

export function getUser(): AuthUser | null {
  const raw = localStorage.getItem(USER_KEY);
  if (!raw) return null;

  try {
    return JSON.parse(raw) as AuthUser;
  } catch {
    return null;
  }
}

// Decodifica el payload del JWT sin verificar la firma (solo para chequear expiración en cliente)
function decodeJwtPayload(token: string): { exp?: number } | null {
  const parts = token.split('.');
  if (parts.length !== 3) return null;

  try {
    const base64 = parts[1].replace(/-/g, '+').replace(/_/g, '/');
    return JSON.parse(atob(base64));
  } catch {
    return null;
  }
}

export function isAuthenticated(): boolean {
  const token = getToken();
  if (!token) return false;

  const payload = decodeJwtPayload(token);
  if (!payload?.exp) return false;

  if (Date.now() >= payload.exp * 1000) {
    clearSession();
    return false;
  }

  return true;
}

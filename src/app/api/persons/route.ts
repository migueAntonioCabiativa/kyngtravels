import { prisma } from '../../lib/prisma'


export async function GET() {
    const clients = await prisma.user.findMany()
    const safeJson = JSON.stringify(
            clients,
            (_, value) => (typeof value === 'bigint' ? value.toString() : value)
        );
    console.log(safeJson)
    return new Response(safeJson, {
    headers: { 'Content-Type': 'application/json' },
  });
}


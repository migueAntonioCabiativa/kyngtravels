import { prisma } from '../../lib/prisma';


export async function GET() {
    const users = await prisma.user.findMany();
    const safeJson = JSON.stringify(
            users,
            (_, value) => {
              return (typeof value === 'bigint' ? value.toString() : value);
            }
        );
    console.log(safeJson)
    return new Response(safeJson, {
        headers: { 'Content-Type': 'application/json' },
      });
}

export async function POST(req: Request) {
  const body = await req.json();

  const data = {
    first_name: body.first_name,
    last_name: body.last_name,
    document_type: body.document_type ?? null,
    document_number: body.document_number ?? null,
    birth_date: body.birth_date ? new Date(body.birth_date) : null,
    email: body.email ?? null,
    phone: body.phone ?? null,
    nationality: body.nationality ?? null,
    is_active: body.is_active ?? true,
  };

  const result = await prisma.user.create({
    data: data // create SIEMPRE objeto
  });

  return Response.json(result);
}
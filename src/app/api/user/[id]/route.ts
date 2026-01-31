import { prisma } from '../../../lib/prisma';
import { NextResponse } from 'next/server';

type Params = {
  params: { id: string };
};

// GET /api/user/:id
export async function GET(_: Request, { params }: Params) {
  const user = await prisma.user.findUnique({
    where: { id: BigInt(params.id) },
  });

  if (!user) {
    return NextResponse.json({ message: 'Usuario no encontrado' }, { status: 404 });
  }

  return NextResponse.json(user);
}

// PUT /api/user/:id
export async function PUT(req: Request, { params }: Params) {
  const body = await req.json();

  const usuario = await prisma.user.update({
    where: { id: BigInt(params.id) },
    data: {
        first_name: body.first_name,
        last_name: body.last_name,
        document_type: body.document_type,
        document_number: body.document_number,
        birth_date: body.birth_date ? new Date(body.birth_date) : null,
        email: body.email,
        phone: body.phone
    }
  });

  return NextResponse.json(usuario);
}

// DELETE /api/user/:id
export async function DELETE(_: Request, { params }: Params) {
  await prisma.user .delete({
    where: { id: BigInt(params.id) },
  });

  return NextResponse.json({ message: 'Usuario eliminado' });
}
from datetime import date
from cep import Transferencia
from cep.exc import TransferNotFoundError

try:
    tr = Transferencia.validar(
        fecha=date(2025, 4, 10),
        clave_rastreo='MBAN01002504100065360870',
        emisor='40012',
        receptor='40014',
        cuenta='5579100397483213',
        monto=10000,
    )
    pdf = tr.descargar()
    with open('CUENCA_MBAN01002504100065360870.pdf', 'wb') as f:
        f.write(pdf)
except TransferNotFoundError as e:
    print('No se encontro la transferencia')
from datetime import date
from cep import Transferencia
from cep.exc import TransferNotFoundError

try:
    tr = Transferencia.validar(
        fecha=date(2019, 4, 12),
        clave_rastreo='MBAN0100254100',
        emisor='90646',  # STP
        receptor='40012',  # BBVA
        cuenta='012180004643051249',
        monto=817, # In cents
    )
    pdf = tr.descargar()
    with open('CUENCA1555093850.pdf', 'wb') as f:
        f.write(pdf)
except TransferNotFoundError as e:
    print('No se encontro la transferencia')

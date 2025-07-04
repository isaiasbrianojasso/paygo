from cep import search

results = search(rfc_emisor='XXX010101XXX', rfc_receptor='YYY010101YYY', monto=123.45)

for result in results:
    print(result)

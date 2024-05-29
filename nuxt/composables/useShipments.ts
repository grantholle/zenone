export type Shipment = {
  id: Number
  tracking_number: String
  weight: String
  origin: String
  destination: String
  status: String
}

export type Activity = {
  location: {
    address?: {
      city?: String
      country?: String
    }
  }
  status: {
    type: String
    description: String
  }
  date: String
  time: String
  gmtDate: String
  gmtOffset: String
  gmtTime: String
}

export type ShipmentResponse = {
  data: Shipment
  activity: Activity[]
}

export const shipments = ref<Shipment[]>([])
export const fetching = ref<boolean>(false)

export async function fetchShipments(): Promise<void> {
  const client = useSanctumClient()

  fetching.value = true

  try {
    const data: { data: Shipment[] } = await client('/api/shipments')
    shipments.value = data.data
  } catch (err) {
    console.error(err)
  }

  fetching.value = false
}

export async function createShipment(tracking_number: string): Promise<void> {
  const client = useSanctumClient()
  const errorStore = useErrorBagStore()

  try {
    const { data } = await client('/api/shipments', {
      method: 'POST',
      body: { tracking_number },
    })
    shipments.value = [
      data,
      ...shipments.value,
    ]
  } catch (err) {
    errorStore.setBag(err)
  }
}

export async function getShipment(tracking_number: string): Promise<ShipmentResponse> {
  const client = useSanctumClient()

  return await client(`/api/shipments/${tracking_number}`)
}

export async function updateShipment(tracking_number: string): Promise<ShipmentResponse> {
  const client = useSanctumClient()

  return await client(`/api/shipments/${tracking_number}`, {
    method: 'PUT',
  })
}

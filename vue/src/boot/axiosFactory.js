import AuthRepository from './Modules/authRepository'
import NetworkRepository from './Modules/networkDirectoryRepository'
import userRepository from './Modules/userRepository'
import userrolesRepository from './Modules/userrolesRepository'
import prpRepository from './Modules/prpRepository'

const repositories = {
  auth: AuthRepository,
  network: NetworkRepository,
  user: userRepository,
  userroles: userrolesRepository,
  prp: prpRepository
}

export const RepositoryFactory = {
  get: name => repositories[name]
}
